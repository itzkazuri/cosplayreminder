<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link } from '@inertiajs/vue3';
import { ref, onMounted } from 'vue';
import { Card, CardHeader, CardTitle, CardContent } from '@/components/ui/card';
import { Table, TableHeader, TableRow, TableHead, TableBody, TableCell } from '@/components/ui/table';
import { Button } from '@/components/ui/button';
import { Pencil, Trash2, PlusCircle } from 'lucide-vue-next';

const props = defineProps({
    events: Array,
});

const events = ref(props.events);

const formatDate = (dateString) => {
    const date = new Date(dateString);
    return date.toLocaleDateString('id-ID', { year: 'numeric', month: 'long', day: 'numeric' });
};

const deleteEvent = async (id) => {
    if (confirm('Are you sure you want to delete this event?')) {
        try {
            const response = await fetch(`/events/${id}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            });
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            events.value = events.value.filter(event => event.id !== id);
            alert('Event deleted successfully!');
        } catch (error) {
            console.error('Error deleting event:', error);
            alert('Failed to delete event.');
        }
    }
};
</script>

<template>
    <Head title="Manage Events" />

    <AuthenticatedLayout>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <Card>
                    <CardHeader class="flex flex-row items-center justify-between space-y-0 pb-2">
                        <CardTitle class="text-2xl font-bold">Event List</CardTitle>
                        <Link :href="route('events.create')">
                            <Button>
                                <PlusCircle class="mr-2 h-4 w-4" /> Add New Event
                            </Button>
                        </Link>
                    </CardHeader>
                    <CardContent>
                        <Table>
                            <TableHeader>
                                <TableRow>
                                    <TableHead>Name</TableHead>
                                    <TableHead>Date</TableHead>
                                    <TableHead>Location</TableHead>
                                    <TableHead>Paid</TableHead>
                                    <TableHead>EO</TableHead>
                                    <TableHead>Poster</TableHead>
                                    <TableHead>Actions</TableHead>
                                </TableRow>
                            </TableHeader>
                            <TableBody>
                                <TableRow v-for="event in events" :key="event.id">
                                    <TableCell class="font-medium">{{ event.name }}</TableCell>
                                    <TableCell>{{ formatDate(event.date) }}</TableCell>
                                    <TableCell>{{ event.location }}</TableCell>
                                    <TableCell>{{ event.is_paid ? 'Yes' : 'No' }}</TableCell>
                                    <TableCell>{{ event.eo }}</TableCell>
                                    <TableCell>
                                        <img :src="event.poster" :alt="event.name" class="w-16 h-16 object-cover rounded" />
                                    </TableCell>
                                    <TableCell>
                                        <div class="flex items-center space-x-2">
                                            <Link :href="route('events.edit', event.id)">
                                                <Button variant="outline" size="icon">
                                                    <Pencil class="h-4 w-4" />
                                                </Button>
                                            </Link>
                                            <Button variant="destructive" size="icon" @click="deleteEvent(event.id)">
                                                <Trash2 class="h-4 w-4" />
                                            </Button>
                                        </div>
                                    </TableCell>
                                </TableRow>
                            </TableBody>
                        </Table>
                    </CardContent>
                </Card>
            </div>
        </div>
    </AuthenticatedLayout>
</template>