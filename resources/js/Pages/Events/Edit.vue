<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, useForm } from '@inertiajs/vue3';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { Button } from '@/components/ui/button';
import { Checkbox } from '@/components/ui/checkbox';
import { Card, CardContent, CardHeader, CardTitle } from '@/components/ui/card';
import { format } from 'date-fns';
import { ref, watch, onMounted } from 'vue';

const props = defineProps({
    event: Object,
});

const form = useForm({
    _method: 'put',
    name: props.event.name,
    date: props.event.date,
    location: props.event.location,
    is_paid: props.event.is_paid,
    eo: props.event.eo,
    ticket_link: props.event.ticket_link,
    poster: null, // Untuk upload file baru
    current_poster: props.event.poster, // Untuk menampilkan poster saat ini
});

const submit = () => {
    form.post(route('events.update', props.event.id), {
        forceFormData: true,
    });
};

const date = ref(form.date ? new Date(form.date) : undefined);
const popoverOpen = ref(false);

watch(date, (newDate) => {
  form.set('date', newDate ? format(newDate, 'yyyy-MM-dd') : '');
  popoverOpen.value = false;
});

</script>

<template>
    <Head :title="`Edit Event: ${form.name}`" />

    <AuthenticatedLayout>
        <div class="py-12">
            <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
                <Card>
                    <CardHeader>
                        <CardTitle>Edit Event</CardTitle>
                    </CardHeader>
                    <CardContent>
                        <form @submit.prevent="submit" class="space-y-6">
                            <div>
                                <Label for="name">Event Name</Label>
                                <Input id="name" type="text" v-model="form.name" required autofocus class="mt-1 block w-full" />
                                <div v-if="form.errors.name" class="text-red-500 text-sm mt-1">{{ form.errors.name }}</div>
                            </div>

                            <div>
                                <Label for="date">Date</Label>
                                <Input id="date" type="date" v-model="form.date" required class="mt-1 block w-full" />
                                <div v-if="form.errors.date" class="text-red-500 text-sm mt-1">{{ form.errors.date }}</div>
                            </div>

                            <div>
                                <Label for="location">Location</Label>
                                <Input id="location" type="text" v-model="form.location" required class="mt-1 block w-full" />
                                <div v-if="form.errors.location" class="text-red-500 text-sm mt-1">{{ form.errors.location }}</div>
                            </div>

                            <div class="flex items-center space-x-2">
                                <Checkbox id="is_paid" v-model:checked="form.is_paid" />
                                <Label for="is_paid">Is Paid Event?</Label>
                                <div v-if="form.errors.is_paid" class="text-red-500 text-sm mt-1">{{ form.errors.is_paid }}</div>
                            </div>

                            <div>
                                <Label for="eo">Event Organizer</Label>
                                <Input id="eo" type="text" v-model="form.eo" required class="mt-1 block w-full" />
                                <div v-if="form.errors.eo" class="text-red-500 text-sm mt-1">{{ form.errors.eo }}</div>
                            </div>

                            <div>
                                <Label for="ticket_link">Ticket Link (Optional)</Label>
                                <Input id="ticket_link" type="text" v-model="form.ticket_link" class="mt-1 block w-full" />
                                <div v-if="form.errors.ticket_link" class="text-red-500 text-sm mt-1">{{ form.errors.ticket_link }}</div>
                            </div>

                            <div>
                                <Label>Current Poster</Label>
                                <div class="mt-1">
                                    <img v-if="form.current_poster" :src="form.current_poster" alt="Current Poster" class="w-32 h-32 object-cover rounded" />
                                    <span v-else class="text-muted-foreground">No poster uploaded.</span>
                                </div>
                                <Label for="poster" class="mt-4 block">Upload New Poster (Optional)</Label>
                                <Input id="poster" type="file" @input="form.poster = $event.target.files[0]" class="mt-1 block w-full" />
                                <div v-if="form.errors.poster" class="text-red-500 text-sm mt-1">{{ form.errors.poster }}</div>
                            </div>

                            <Button type="submit" :disabled="form.processing">Update Event</Button>
                        </form>
                    </CardContent>
                </Card>
            </div>
        </div>
    </AuthenticatedLayout>
</template>