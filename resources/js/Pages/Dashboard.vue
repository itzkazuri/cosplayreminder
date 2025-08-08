<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link, usePage } from '@inertiajs/vue3';
import { ref, onMounted } from 'vue';
import { Card, CardContent, CardHeader, CardTitle } from '@/components/ui/card';
import { Button } from '@/components/ui/button';
import { PlusCircle, Calendar, ListTodo, TrendingUp } from 'lucide-vue-next';
import { format } from 'date-fns';

const { props } = usePage();
const user = props.auth.user;

const welcomeMessage = ref('');
const totalEvents = ref(0);
const upcomingEvents = ref([]);
const recentEvent = ref(null);

const getWelcomeMessage = () => {
    const hour = new Date().getHours();
    if (hour < 12) {
        welcomeMessage.value = 'Good Morning';
    } else if (hour < 18) {
        welcomeMessage.value = 'Good Afternoon';
    } else {
        welcomeMessage.value = 'Good Evening';
    }
};

const fetchDashboardData = async () => {
    try {
        const response = await fetch('/api/events');
        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }
        const data = await response.json();

        totalEvents.value = data.length;

        const now = new Date();
        upcomingEvents.value = data
            .filter(event => new Date(event.date) >= now)
            .sort((a, b) => new Date(a.date) - new Date(b.date))
            .slice(0, 3); // Ambil 3 event mendatang terdekat

        recentEvent.value = data
            .sort((a, b) => new Date(b.created_at) - new Date(a.created_at))
            .slice(0, 1)[0]; // Ambil 1 event terbaru

    } catch (error) {
        console.error('Error fetching dashboard data:', error);
    }
};

const formatDate = (dateString) => {
    if (!dateString) return '';
    const date = new Date(dateString);
    return format(date, 'PPP'); // Contoh: Oct 27, 2023
};

onMounted(() => {
    getWelcomeMessage();
    fetchDashboardData();
});
</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
                <!-- Welcome Message -->
                <Card class="p-6">
                    <CardTitle class="text-3xl font-bold text-gray-900">
                        {{ welcomeMessage }}, {{ user.name }}!
                    </CardTitle>
                    <CardContent class="text-gray-600 mt-2">
                        Here's a quick overview of your cosplay events.
                    </CardContent>
                </Card>

                <!-- Summary Cards -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <Card>
                        <CardHeader class="flex flex-row items-center justify-between space-y-0 pb-2">
                            <CardTitle class="text-sm font-medium">Total Events</CardTitle>
                            <ListTodo class="h-4 w-4 text-muted-foreground" />
                        </CardHeader>
                        <CardContent>
                            <div class="text-2xl font-bold">{{ totalEvents }}</div>
                            <p class="text-xs text-muted-foreground">Total events recorded</p>
                        </CardContent>
                    </Card>

                    <Card>
                        <CardHeader class="flex flex-row items-center justify-between space-y-0 pb-2">
                            <CardTitle class="text-sm font-medium">Upcoming Events</CardTitle>
                            <Calendar class="h-4 w-4 text-muted-foreground" />
                        </CardHeader>
                        <CardContent>
                            <div v-if="upcomingEvents.length > 0">
                                <div v-for="event in upcomingEvents" :key="event.id" class="text-sm mb-1">
                                    <span class="font-medium">{{ event.name }}</span> - {{ formatDate(event.date) }}
                                </div>
                            </div>
                            <div v-else class="text-sm text-muted-foreground">No upcoming events.</div>
                        </CardContent>
                    </Card>

                    <Card>
                        <CardHeader class="flex flex-row items-center justify-between space-y-0 pb-2">
                            <CardTitle class="text-sm font-medium">Recent Added Event</CardTitle>
                            <TrendingUp class="h-4 w-4 text-muted-foreground" />
                        </CardHeader>
                        <CardContent>
                            <div v-if="recentEvent">
                                <img :src="recentEvent.poster" :alt="recentEvent.name" class="w-16 h-16 object-cover rounded mb-2" />
                                <div class="text-lg font-bold">{{ recentEvent.name }}</div>
                                <p class="text-sm text-muted-foreground">Added on {{ formatDate(recentEvent.created_at) }}</p>
                            </div>
                            <div v-else class="text-sm text-muted-foreground">No recent events.</div>
                        </CardContent>
                    </Card>
                </div>

                <!-- Create New Event Button -->
                <div class="text-center">
                    <Link :href="route('events.create')">
                        <Button size="lg">
                            <PlusCircle class="mr-2 h-5 w-5" /> Create New Event
                        </Button>
                    </Link>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
