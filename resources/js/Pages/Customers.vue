<script setup>
import PrimaryButton from '@/Components/PrimaryButton.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link } from '@inertiajs/vue3';
</script>

<script>
export default {
    data: function () {
        return {
            loading: false,
            customers: [],
            links: [],
            meta: [],
            api_customers: route('customers.index'),
            api_page: 1
        }
    },
    mounted() {
        this.getCustomers();
    },
    methods: {
        getCustomers() {
            axios.get(`${this.api_customers}?page=${this.api_page}`).then(res => {
                this.customers = res.data.data
                this.links = res.data.links
                this.meta = res.data.meta
            });
        },
        setPage(page_number) {
            this.api_page = page_number
            this.getCustomers()
        }
    }
}
</script>

<template>
    <Head title="Customers" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Customers</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
                <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                    <PrimaryButton>
                        <Link
                            v-if="$page.props.auth.user"
                            :href="route('customers.create')"
                            class="text-primary transition duration-150 ease-in-out hover:text-primary-600 focus:text-primary-600 active:text-primary-700"
                            >Add Customer</Link>
                    </PrimaryButton>
                </div>
                <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                    <table class="min-w-full leading-normal border-2 dark:border-gray-500">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Address</th>
                            <th>Phone Number</th>
                            <th>&nbsp;</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr v-for="customer in customers">
                            <td>{{ customer.id }}</td>
                            <td>{{ customer.name }}</td>
                            <td>{{ customer.email }}</td>
                            <td>{{ customer.address }}</td>
                            <td>{{ customer.phone_number }}</td>
                            <td>
                                <SecondaryButton>
                                    <Link
                                        v-if="$page.props.auth.user"
                                        :href="route('customers.edit', customer.id)"
                                        class="text-warning transition duration-150 ease-in-out hover:text-warning-600 focus:text-warning-600 active:text-warning-700"
                                        >Edit</Link>
                                    </SecondaryButton>
                            </td>
                        </tr>
                    </tbody>
                    </table>
                </div>
                <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                    <SecondaryButton v-for="n in meta.last_page" :disabled="n == meta.current_page" @click="setPage(n)">
                        {{ n }}
                    </SecondaryButton>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
