<script setup>
import { ref } from 'vue';
import { Button } from '@/components/ui/button';
import { Card, CardContent, CardHeader, CardTitle } from '@/components/ui/card';
import { Badge } from '@/components/ui/badge';
import { Calendar, MapPin, Users, Ticket } from 'lucide-vue-next';
import Navbar from '@/Components/Navbar.vue';
import Footer from '@/Components/Footer.vue';
import { Head, Link } from '@inertiajs/vue3';

const props = defineProps({
  events: Array,
});

const featuredEvents = ref(props.events);

const formatDate = (dateString) => {
  const date = new Date(dateString);
  return date.toLocaleDateString('id-ID', { 
    year: 'numeric', 
    month: 'long', 
    day: 'numeric' 
  });
};

const openTicketLink = (link) => {
  window.open(link, '_blank');
};
</script>

<template>
  <Head title="All Events" />
  <div class="min-h-screen bg-gradient-to-br from-purple-50 via-pink-50 to-blue-50">
    <!-- Navbar Component -->
    <Navbar />
    
    <!-- Events Section -->
    <section class="py-16 px-4">
      <div class="max-w-7xl mx-auto">
        <div class="text-center mb-12">
          <h2 class="text-3xl font-bold text-gray-900 mb-4">Semua Event Cosplay</h2>
          <p class="text-gray-600 max-w-2xl mx-auto">
            Jelajahi semua event cosplay terbaik di seluruh Indonesia.
          </p>
        </div>

        <!-- Event Cards Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
          <Card v-for="event in featuredEvents" :key="event.id" class="overflow-hidden hover:shadow-lg transition-shadow duration-300">
            <div class="relative">
              <img 
                :src="event.poster" 
                :alt="event.name"
                class="w-full h-48 object-cover"
              />
              <Badge 
                :variant="event.is_paid ? 'destructive' : 'secondary'" 
                class="absolute top-2 right-2"
              >
                {{ event.is_paid ? 'Berbayar' : 'Gratis' }}
              </Badge>
            </div>
            <CardHeader>
              <CardTitle class="text-lg">{{ event.name }}</CardTitle>
              <div class="flex flex-col text-sm text-gray-600 space-y-1">
                <div class="flex items-center">
                  <Calendar class="mr-2 h-4 w-4" />
                  <span>{{ formatDate(event.date) }}</span>
                </div>
                <div class="flex items-center">
                  <MapPin class="mr-2 h-4 w-4" />
                  <span>{{ event.location }}</span>
                </div>
              </div>
            </CardHeader>
            <CardContent>
              <div class="flex items-center justify-between">
                <div class="flex items-center text-sm text-gray-600">
                  <Users class="mr-2 h-4 w-4" />
                  <span>{{ event.eo }}</span>
                </div>
                <Button 
                  v-if="event.is_paid && event.ticket_link" 
                  variant="outline" 
                  size="sm"
                  @click="openTicketLink(event.ticket_link)"
                >
                  <Ticket class="mr-2 h-4 w-4" />
                  Beli Tiket
                </Button>
                <!-- Simplified Detail Button for debugging -->
                <a :href="route('event.detail', event.id)" class="text-blue-500 hover:underline text-sm">Detail Link</a>
              </div>
            </CardContent>
          </Card>
        </div>

        <div v-if="featuredEvents.length === 0" class="text-center text-gray-500">
          No events found.
        </div>
      </div>
    </section>

    <!-- Footer Component -->
    <Footer />
  </div>
</template>