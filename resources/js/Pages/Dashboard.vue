<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link } from '@inertiajs/vue3';
import { Card, CardContent, CardHeader, CardTitle } from '@/components/ui/card';
import { Button } from '@/components/ui/button';

</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <Card>
                    <CardHeader>
                        <CardTitle>Welcome to your Dashboard!</CardTitle>
                    </CardHeader>
                    <CardContent>
                        <p class="text-gray-900 mb-4">
                            You're logged in. From here, you can manage your cosplay events.
                        </p>
                        <Link :href="route('events.index')">
                            <Button>
                                Go to Manage Events
                            </Button>
                        </Link>
                    </CardContent>
                </Card>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
