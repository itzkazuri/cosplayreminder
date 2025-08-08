<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, useForm } from '@inertiajs/vue3';
import { Input } from '@/Components/ui/input';
import { Label } from '@/Components/ui/label';
import { Button } from '@/Components/ui/button';
import { Checkbox } from '@/Components/ui/checkbox';

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
    poster: null,
});

const submit = () => {
    form.post(route('events.update', props.event.id));
};
</script>

<template>
    <Head title="Edit Event" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Edit Event</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <form @submit.prevent="submit" class="space-y-4">
                            <div>
                                <Label for="name">Event Name</Label>
                                <Input id="name" type="text" v-model="form.name" required autofocus />
                                <div v-if="form.errors.name" class="text-red-500 text-sm">{{ form.errors.name }}</div>
                            </div>

                            <div>
                                <Label for="date">Date</Label>
                                <Input id="date" type="date" v-model="form.date" required />
                                <div v-if="form.errors.date" class="text-red-500 text-sm">{{ form.errors.date }}</div>
                            </div>

                            <div>
                                <Label for="location">Location</Label>
                                <Input id="location" type="text" v-model="form.location" required />
                                <div v-if="form.errors.location" class="text-red-500 text-sm">{{ form.errors.location }}</div>
                            </div>

                            <div class="flex items-center space-x-2">
                                <Checkbox id="is_paid" v-model:checked="form.is_paid" />
                                <Label for="is_paid">Is Paid Event?</Label>
                                <div v-if="form.errors.is_paid" class="text-red-500 text-sm">{{ form.errors.is_paid }}</div>
                            </div>

                            <div>
                                <Label for="eo">Event Organizer</Label>
                                <Input id="eo" type="text" v-model="form.eo" required />
                                <div v-if="form.errors.eo" class="text-red-500 text-sm">{{ form.errors.eo }}</div>
                            </div>

                            <div>
                                <Label for="ticket_link">Ticket Link (Optional)</Label>
                                <Input id="ticket_link" type="text" v-model="form.ticket_link" />
                                <div v-if="form.errors.ticket_link" class="text-red-500 text-sm">{{ form.errors.ticket_link }}</div>
                            </div>

                            <div>
                                <Label for="poster">Poster (Leave blank to keep current)</Label>
                                <Input id="poster" type="file" @input="form.poster = $event.target.files[0]" />
                                <div v-if="form.errors.poster" class="text-red-500 text-sm">{{ form.errors.poster }}</div>
                                <div v-if="event.poster" class="mt-2">
                                    Current Poster: <a :href="`/storage/${event.poster}`" target="_blank" class="text-blue-500 hover:underline">View Poster</a>
                                </div>
                            </div>

                            <Button type="submit" :disabled="form.processing">Update Event</Button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
