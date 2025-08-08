<template>
  <div class="min-h-screen bg-gradient-to-br from-purple-50 via-pink-50 to-blue-50">
    <!-- Navbar Component -->
    <Navbar />
    
    <!-- Hero Section -->
    <section class="py-20 px-4 text-center">
      <div class="max-w-4xl mx-auto">
        <h1 class="text-5xl md:text-6xl font-bold text-gray-900 mb-6">
          <span class="bg-gradient-to-r from-purple-600 to-pink-600 bg-clip-text text-transparent">
            Cosplay Reminder
          </span>
        </h1>
        <p class="text-xl text-gray-600 mb-8 max-w-2xl mx-auto">
          Jangan sampai terlewat event cosplay impianmu! Dapatkan reminder untuk semua event cosplay terbaru di Indonesia.
        </p>
        <Button size="lg" class="bg-gradient-to-r from-purple-600 to-pink-600 hover:from-purple-700 hover:to-pink-700 text-white px-8 py-3">
          <Calendar class="mr-2 h-5 w-5" />
          Lihat Event Terbaru
        </Button>
      </div>
    </section>

    <!-- Featured Events Section -->
    <section class="py-16 px-4">
      <div class="max-w-7xl mx-auto">
        <div class="text-center mb-12">
          <h2 class="text-3xl font-bold text-gray-900 mb-4">Event Cosplay Terbaru</h2>
          <p class="text-gray-600 max-w-2xl mx-auto">
            Temukan event cosplay terbaik di seluruh Indonesia dengan berbagai tema menarik
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
              <div class="flex items-center text-sm text-gray-600 space-y-1">
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
                <Button v-else variant="outline" size="sm">
                  Detail
                </Button>
              </div>
            </CardContent>
          </Card>
        </div>

        <!-- Load More Button -->
        <div class="text-center">
          <Button variant="outline" size="lg" @click="loadMoreEvents">
            Lihat Lebih Banyak Event
          </Button>
        </div>
      </div>
    </section>

    <!-- Features Section -->
    <section class="py-16 px-4 bg-white">
      <div class="max-w-6xl mx-auto">
        <div class="text-center mb-12">
          <h2 class="text-3xl font-bold text-gray-900 mb-4">Kenapa Pilih Cosplay Reminder?</h2>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
          <Card class="text-center p-6 border-none shadow-md hover:shadow-lg transition-shadow">
            <div class="bg-purple-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
              <Bell class="h-8 w-8 text-purple-600" />
            </div>
            <h3 class="text-xl font-semibold mb-2">Reminder Otomatis</h3>
            <p class="text-gray-600">Dapatkan notifikasi sebelum event dimulai agar tidak terlewat</p>
          </Card>
          
          <Card class="text-center p-6 border-none shadow-md hover:shadow-lg transition-shadow">
            <div class="bg-pink-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
              <MapPin class="h-8 w-8 text-pink-600" />
            </div>
            <h3 class="text-xl font-semibold mb-2">Lokasi Lengkap</h3>
            <p class="text-gray-600">Informasi lokasi event yang akurat dan mudah diakses</p>
          </Card>
          
          <Card class="text-center p-6 border-none shadow-md hover:shadow-lg transition-shadow">
            <div class="bg-blue-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
              <Star class="h-8 w-8 text-blue-600" />
            </div>
            <h3 class="text-xl font-semibold mb-2">Event Terpilih</h3>
            <p class="text-gray-600">Hanya event cosplay terbaik dan terpercaya yang kami tampilkan</p>
          </Card>
        </div>
      </div>
    </section>

    <!-- CTA Section -->
    <section class="py-16 px-4 bg-gradient-to-r from-purple-600 to-pink-600">
      <div class="max-w-4xl mx-auto text-center">
        <h2 class="text-3xl font-bold text-white mb-4">
          Siap untuk Event Cosplay Berikutnya?
        </h2>
        <p class="text-xl text-purple-100 mb-8">
          Jangan sampai terlewat event cosplay impianmu. Bergabunglah dengan ribuan cosplayer lainnya!
        </p>
        <div class="flex flex-col sm:flex-row gap-4 justify-center">
          <Button size="lg" variant="secondary" class="bg-white text-purple-600 hover:bg-gray-50">
            <Calendar class="mr-2 h-5 w-5" />
            Lihat Semua Event
          </Button>
          <Button size="lg" variant="outline" class="border-white text-white hover:bg-white hover:text-purple-600">
            <Bell class="mr-2 h-5 w-5" />
            Aktifkan Reminder
          </Button>
        </div>
      </div>
    </section>

    <!-- Footer Component -->
    <Footer />
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import { Button } from '@/components/ui/button'
import { Card, CardContent, CardHeader, CardTitle } from '@/components/ui/card'
import { Badge } from '@/components/ui/badge'
import { Calendar, MapPin, Users, Ticket, Bell, Star } from 'lucide-vue-next'
import Navbar from '@/Components/Navbar.vue'
import Footer from '@/Components/Footer.vue'

// Reactive data
const featuredEvents = ref([])
const loading = ref(false)

// Sample data - ini nanti bisa diganti dengan API call
const sampleEvents = [
  {
    id: 1,
    name: 'Indonesia Comic Con 2024',
    date: '2024-12-15',
    location: 'Jakarta Convention Center',
    is_paid: true,
    eo: 'Reed Panorama',
    ticket_link: 'https://instagram.com/indonesiacomiccon',
    poster: '/api/placeholder/300/200'
  },
  {
    id: 2,
    name: 'Cosplay Festival Surabaya',
    date: '2024-11-20',
    location: 'Surabaya Town Square',
    is_paid: false,
    eo: 'Cosplay Community SBY',
    ticket_link: null,
    poster: '/api/placeholder/300/200'
  },
  {
    id: 3,
    name: 'Anime Festival Asia Indonesia',
    date: '2024-12-01',
    location: 'ICE BSD Tangerang',
    is_paid: true,
    eo: 'SOZO',
    ticket_link: 'https://afa-id.com',
    poster: '/api/placeholder/300/200'
  }
]

// Methods
const formatDate = (dateString) => {
  const date = new Date(dateString)
  return date.toLocaleDateString('id-ID', { 
    year: 'numeric', 
    month: 'long', 
    day: 'numeric' 
  })
}

const openTicketLink = (link) => {
  window.open(link, '_blank')
}

const loadMoreEvents = () => {
  // Logic untuk load more events dari API
  console.log('Loading more events...')
}

const fetchEvents = async () => {
  loading.value = true
  try {
    const response = await fetch('/api/events');
    if (!response.ok) {
      throw new Error(`HTTP error! status: ${response.status}`);
    }
    const data = await response.json();
    featuredEvents.value = data;
  } catch (error) {
    console.error('Error fetching events:', error);
  } finally {
    loading.value = false;
  }
}

// Lifecycle hooks
onMounted(() => {
  fetchEvents()
})
</script>

<style scoped>
/* Custom styles jika diperlukan */
.bg-gradient-to-br {
  background: linear-gradient(to bottom right, var(--tw-gradient-stops));
}

.bg-clip-text {
  background-clip: text;
  -webkit-background-clip: text;
}
</style>