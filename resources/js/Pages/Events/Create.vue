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

const form = useForm({
    name: '',
    date: '',
    location: '',
    is_paid: false,
    eo: '',
    ticket_link: '',
    poster: null,
});

const submit = () => {
    form.post(route('events.store'), {
        forceFormData: true,
    });
};

// Tidak perlu ref date dan popoverOpen lagi jika menggunakan input type="date"
// const date = ref(form.date ? new Date(form.date) : undefined);
// const popoverOpen = ref(false);

// watch(date, (newDate) => {
//   console.log('Date changed:', newDate);
//   form.set('date', newDate ? format(newDate, 'yyyy-MM-dd') : '');
//   popoverOpen.value = false;
// });

</script>

<template>
    <Head title="Create Event" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Create New Event</h2>
        </template>

        <div class="py-12">
            <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
                <Card>
                    <CardHeader>
                        <CardTitle>Event Details</CardTitle>
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
                                <Label for="poster">Poster</Label>
                                <Input id="poster" type="file" @input="form.poster = $event.target.files[0]" required class="mt-1 block w-full" />
                                <div v-if="form.errors.poster" class="text-red-500 text-sm mt-1">{{ form.errors.poster }}</div>
                            </div>

                            <Button type="submit" :disabled="form.processing">Create Event</Button>
                        </form>
                    </CardContent>
                </Card>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
