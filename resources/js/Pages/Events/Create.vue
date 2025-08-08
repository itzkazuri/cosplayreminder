<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, useForm } from '@inertiajs/vue3';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { Button } from '@/components/ui/button';
import { Checkbox } from '@/components/ui/checkbox';
import { Card, CardContent, CardHeader, CardTitle } from '@/components/ui/card';
import { Calendar } from '@/components/ui/calendar';
import { Popover, PopoverContent, PopoverTrigger } from '@/components/ui/popover';
import { CalendarIcon } from 'lucide-vue-next';
import { format } from 'date-fns';
import { cn } from '~/lib/utils';
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
    form.post(route('events.store'));
};

const date = ref(form.date ? new Date(form.date) : undefined);
const popoverOpen = ref(false); // State untuk mengontrol popover

watch(date, (newDate) => {
  console.log('Date changed:', newDate);
  form.set('date', newDate ? format(newDate, 'yyyy-MM-dd') : ''); // Perubahan di sini
  popoverOpen.value = false; // Tutup popover setelah tanggal dipilih
});

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
                                <Popover v-model:open="popoverOpen"> <!-- Bind popoverOpen di sini -->
                                    <PopoverTrigger as-child>
                                        <Button
                                            variant="outline"
                                            :class="cn(
                                                'w-full justify-start text-left font-normal',
                                                !date && 'text-muted-foreground',
                                            )"
                                        >
                                            <CalendarIcon class="mr-2 h-4 w-4" />
                                            {{ date ? format(date, 'PPP') : 'Pick a date' }}
                                        </Button>
                                    </PopoverTrigger>
                                    <PopoverContent class="w-auto p-0">
                                        <Calendar v-model:selected="date" initial-focus />
                                    </PopoverContent>
                                </Popover>
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
