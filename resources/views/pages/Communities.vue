<script setup lang="ts">
import {Head} from '@inertiajs/inertia-vue3'
import CommunityCard from '@/views/components/community-card.vue'
import {ref} from 'vue'
import {Inertia} from '@inertiajs/inertia'

defineProps<{
    communities: Object
    locations: Object
    description: String
}>()

const filter_location = ref('');
const sort_price = ref('');
const sort_sqft = ref('');

function filterAndSort() {
    Inertia.get('/', {
        'filter_location': filter_location.value,
        'sort_price': sort_price.value,
        'sort_sqft': sort_sqft.value
    }, {preserveState: true, preserveScroll: true});
}
</script>


<template layout>
    <div class="hero-shadow">
        <img src="@/images/newyork_1920.jpg" class="hero-image">
    </div>
    <Head title="Communities"/>
    <div class="row mt-10 mb-10">
        <div class="col text-center">
            <h1 class="font-semibold text-4xl">New Homes For Sale in New York</h1>
            <h3 class="text-gray-600 text-2xl pb-4">Find Your Dream Home In Beautiful New York City</h3>
            <p class="text-gray-600">{{ description }}</p>
        </div>
    </div>

    <form @submit.prevent="submit">
        <div class="columns-1 mb-10">
            <div class="text-right space-x-4 mx-10 ">
                <select
                    @change.prevent="filterAndSort" v-model="filter_location"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 p-2.5">
                    <option value="">Location:</option>
                    <option v-for="(location, key) in locations" :value="key">
                        {{ location }}
                    </option>
                </select>
                <select
                    @change.prevent="filterAndSort" v-model="sort_price"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 p-2.5">
                    <option value="" selected>Price:</option>
                    <option value="desc">Price: High to Low</option>
                    <option value="asc">Price: Low to High</option>
                </select>
                <select
                    @change.prevent="filterAndSort" v-model="sort_sqft"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 p-2.5">
                    <option value="" selected>Square Feet:</option>
                    <option value="desc">Sq ft: High to Low</option>
                    <option value="asc">Sq ft: Low to High</option>
                </select>
            </div>
        </div>
    </form>

    <main>
        <div class="lg:flex lg:flex-wrap lg:-mx-3">
            <div class="lg:w-1/3 px-3 pb-6" v-for="community in communities.data" :key="community.id">
                <CommunityCard :community="community"/>
            </div>
        </div>
    </main>
</template>
