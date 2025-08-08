<script setup>
import { Link, usePage } from '@inertiajs/vue3';
import { Button } from '@/components/ui/button';
import { Sheet, SheetContent, SheetTrigger } from '@/components/ui/sheet';
import { Menu } from 'lucide-vue-next';

const { props } = usePage();
const user = props.auth.user;
</script>

<template>
  <nav class="bg-white dark:bg-gray-800 shadow-md py-3">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex justify-between items-center h-16">
      <!-- Logo/Brand -->
      <div class="flex-shrink-0">
        <Link :href="route('welcome')">
          <h1 class="text-2xl font-extrabold text-gray-900 dark:text-white tracking-tight">
            Cosplay Reminder
          </h1>
        </Link>
      </div>

      <!-- Desktop Navigation -->
      <div class="hidden sm:flex space-x-6 items-center">
        <Link :href="route('welcome')">
          <Button variant="ghost" class="text-gray-700 dark:text-gray-300 hover:text-purple-600 dark:hover:text-purple-400">
            Home
          </Button>
        </Link>
        <Link :href="route('events.index')">
          <Button variant="ghost" class="text-gray-700 dark:text-gray-300 hover:text-purple-600 dark:hover:text-purple-400">
            Events
          </Button>
        </Link>
        <Link v-if="user" :href="route('dashboard')">
          <Button variant="ghost" class="text-gray-700 dark:text-gray-300 hover:text-purple-600 dark:hover:text-purple-400">
            Dashboard
          </Button>
        </Link>
      </div>

      <!-- Mobile Navigation (Sheet) -->
      <div class="sm:hidden">
        <Sheet>
          <SheetTrigger as-child>
            <Button variant="ghost" size="icon">
              <Menu class="h-6 w-6" />
            </Button>
          </SheetTrigger>
          <SheetContent side="right" class="w-[250px] sm:w-[300px]">
            <nav class="flex flex-col gap-4 pt-8">
              <Link :href="route('welcome')">
                <Button variant="ghost" class="w-full justify-start text-lg">
                  Home
                </Button>
              </Link>
              <Link :href="route('events.index')">
                <Button variant="ghost" class="w-full justify-start text-lg">
                  Events
                </Button>
              </Link>
              <Link v-if="user" :href="route('dashboard')">
                <Button variant="ghost" class="w-full justify-start text-lg">
                  Dashboard
                </Button>
              </Link>
            </nav>
          </SheetContent>
        </Sheet>
      </div>
    </div>
  </nav>
</template>