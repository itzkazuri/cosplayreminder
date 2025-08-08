<script setup>
import { ref } from 'vue';
import { Link, usePage } from '@inertiajs/vue3';
import { Button } from '@/components/ui/button';
import { Sheet, SheetContent, SheetTrigger } from '@/components/ui/sheet';
import { DropdownMenu, DropdownMenuContent, DropdownMenuItem, DropdownMenuLabel, DropdownMenuSeparator, DropdownMenuTrigger } from '@/components/ui/dropdown-menu';
import { Menu, UserCircle, Sun, Moon } from 'lucide-vue-next';
import { useDarkMode } from '@/Composables/useDarkMode';

const showingNavigationDropdown = ref(false);
const { props } = usePage();
const user = props.auth.user;
const { isDarkMode, toggleDarkMode } = useDarkMode();
</script>

<template>
    <div>
        <div class="min-h-screen bg-gray-100">
            <nav class="bg-white dark:bg-gray-800 shadow-md py-3">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex justify-between items-center h-16">
                    <!-- Logo/Brand -->
                    <div class="flex-shrink-0">
                        <Link :href="route('dashboard')">
                            <h1 class="text-2xl font-extrabold text-gray-900 dark:text-white tracking-tight">
                                Admin Dashboard
                            </h1>
                        </Link>
                    </div>

                    <!-- Desktop Navigation -->
                    <div class="hidden sm:flex space-x-6 items-center">
                        <Link :href="route('dashboard')">
                            <Button variant="ghost" class="text-gray-700 dark:text-gray-300 hover:text-purple-600 dark:hover:text-purple-400">
                                Dashboard
                            </Button>
                        </Link>
                        <Link :href="route('events.index')">
                            <Button variant="ghost" class="text-gray-700 dark:text-gray-300 hover:text-purple-600 dark:hover:text-purple-400">
                                Manage Events
                            </Button>
                        </Link>

                        <!-- Dark Mode Toggle -->
                        <Button variant="ghost" size="icon" @click="toggleDarkMode">
                            <Sun v-if="isDarkMode" class="h-6 w-6 text-yellow-500" />
                            <Moon v-else class="h-6 w-6 text-gray-500" />
                        </Button>

                        <!-- User Dropdown -->
                        <DropdownMenu>
                            <DropdownMenuTrigger as-child>
                                <Button variant="ghost" class="relative h-9 w-9 rounded-full">
                                    <UserCircle class="h-6 w-6" />
                                </Button>
                            </DropdownMenuTrigger>
                            <DropdownMenuContent class="w-56" align="end">
                                <DropdownMenuLabel class="font-normal">
                                    <div class="flex flex-col space-y-1">
                                        <p class="text-sm font-medium leading-none">{{ user.name }}</p>
                                        <p class="text-xs leading-none text-muted-foreground">
                                            {{ user.email }}
                                        </p>
                                    </div>
                                </DropdownMenuLabel>
                                <DropdownMenuSeparator />
                                <DropdownMenuItem as-child>
                                    <Link :href="route('profile.edit')">
                                        Profile
                                    </Link>
                                </DropdownMenuItem>
                                <DropdownMenuItem as-child>
                                    <Link :href="route('logout')" method="post" as="button">
                                        Log Out
                                    </Link>
                                </DropdownMenuItem>
                            </DropdownMenuContent>
                        </DropdownMenu>
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
                                    <Link :href="route('dashboard')">
                                        <Button variant="ghost" class="w-full justify-start text-lg">
                                            Dashboard
                                        </Button>
                                    </Link>
                                    <Link :href="route('events.index')">
                                        <Button variant="ghost" class="w-full justify-start text-lg">
                                            Manage Events
                                        </Button>
                                    </Link>

                                    <!-- Dark Mode Toggle for Mobile -->
                                    <Button variant="ghost" class="w-full justify-start text-lg" @click="toggleDarkMode">
                                        <Sun v-if="isDarkMode" class="mr-2 h-6 w-6 text-yellow-500" />
                                        <Moon v-else class="mr-2 h-6 w-6 text-gray-500" />
                                        {{ isDarkMode ? 'Light Mode' : 'Dark Mode' }}
                                    </Button>

                                    <DropdownMenu>
                                        <DropdownMenuTrigger as-child>
                                            <Button variant="ghost" class="w-full justify-start text-lg">
                                                <UserCircle class="mr-2 h-6 w-6" /> Profile
                                            </Button>
                                        </DropdownMenuTrigger>
                                        <DropdownMenuContent class="w-56" align="start">
                                            <DropdownMenuLabel class="font-normal">
                                                <div class="flex flex-col space-y-1">
                                                    <p class="text-sm font-medium leading-none">{{ user.name }}</p>
                                                    <p class="text-xs leading-none text-muted-foreground">
                                                        {{ user.email }}
                                                    </p>
                                                </div>
                                            </DropdownMenuLabel>
                                            <DropdownMenuSeparator />
                                            <DropdownMenuItem as-child>
                                                <Link :href="route('profile.edit')">
                                                        Profile
                                                    </Link>
                                                </DropdownMenuItem>
                                                <DropdownMenuItem as-child>
                                                    <Link :href="route('logout')" method="post" as="button">
                                                        Log Out
                                                    </Link>
                                                </DropdownMenuItem>
                                            </DropdownMenuContent>
                                        </DropdownMenu>
                                    </nav>
                                </SheetContent>
                            </Sheet>
                        </div>
                    </div>
                </nav>

                <!-- Page Content -->
                <main>
                    <slot />
                </main>
            </div>
        </div>
    </template>
