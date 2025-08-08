<script setup>
import { ref } from 'vue';
import { Button } from '@/components/ui/button';
import { Card, CardContent, CardHeader, CardTitle } from '@/components/ui/card';
import { Badge } from '@/components/ui/badge';
import { Calendar, MapPin, Users, Ticket, ArrowLeft } from 'lucide-vue-next';
import Navbar from '@/Components/Navbar.vue';
import Footer from '@/Components/Footer.vue';
import { Head, Link } from '@inertiajs/vue3';
import { format } from 'date-fns';

const props = defineProps({
  event: Object,
});

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
  <Head :title="event.name" />
  <div class="min-h-screen bg-gradient-to-br from-purple-50 via-pink-50 to-blue-50">
    <!-- Navbar Component -->
    <Navbar />
    
    <!-- Event Detail Section -->
    <section class="py-16 px-4">
      <div class="max-w-4xl mx-auto bg-white rounded-lg shadow-lg overflow-hidden">
        <div class="relative">
          <img 
            :src="event.poster" 
            :alt="event.name"
            class="w-full h-96 object-cover"
          />
          <Badge 
            :variant="event.is_paid ? 'destructive' : 'secondary'" 
            class="absolute top-4 right-4 text-lg px-4 py-2"
          >
            {{ event.is_paid ? 'Berbayar' : 'Gratis' }}
          </Badge>
        </div>
        
        <div class="p-6">
          <h1 class="text-4xl font-bold text-gray-900 mb-4">{{ event.name }}</h1>
          
          <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6 text-gray-700">
            <div class="flex items-center text-lg">
              <Calendar class="mr-3 h-6 w-6 text-purple-600" />
              <span>{{ formatDate(event.date) }}</span>
            </div>
            <div class="flex items-center text-lg">
              <MapPin class="mr-3 h-6 w-6 text-pink-600" />
              <span>{{ event.location }}</span>
            </div>
            <div class="flex items-center text-lg">
              <Users class="mr-3 h-6 w-6 text-blue-600" />
              <span>{{ event.eo }}</span>
            </div>
          </div>

          <div class="mt-8 flex flex-col sm:flex-row gap-4">
            <Button 
              v-if="event.is_paid && event.ticket_link" 
              size="lg" 
              class="bg-gradient-to-r from-purple-600 to-pink-600 hover:from-purple-700 hover:to-pink-700 text-white px-8 py-3"
              @click="openTicketLink(event.ticket_link)"
            >
              <Ticket class="mr-2 h-5 w-5" />
              Beli Tiket
            </Button>
            <Link :href="route('public.events')">
              <Button variant="outline" size="lg" class="px-8 py-3">
                <ArrowLeft class="mr-2 h-5 w-5" />
                Kembali ke Daftar Event
              </Button>
            </Link>
          </div>
        </div>
      </div>
    </section>

    <!-- Footer Component -->
    <Footer />
  </div>
</template>
