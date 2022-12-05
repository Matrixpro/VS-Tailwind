<script setup lang="ts">
import {Head} from '@inertiajs/inertia-vue3'
import CommunityCard from '@/views/components/community-card.vue'
import { reactive, ref, computed } from 'vue'
import { Inertia } from '@inertiajs/inertia'

defineProps<{
    communities: Object
    locations_select: Object
    description: String
    filter_location_selected: String
    sort_price_selected: Number
    sort_sqft_selected: Number
}>()

const filter_location_select = ref('filter_location-reset');
const sort_location_select = ref('sort_price-DESC');

function filterLocation() {
    Inertia.post('/', {
       'filter_data': filter_location_select.value
    }, { preserveState: true, preserveScroll: true });
}

function sortLocation() {
    Inertia.post('/', {
        'filter_data': sort_location_select.value
    }, { preserveState: true, preserveScroll: true });
}

//console.log(filter_location_selected);
</script>

<style>
.center-cropped {
    object-fit: none; /* Do not scale the image */
    object-position: center; /* Center the image within the element */
    height: 300px;
    width: 490px;
}
.navbar {
    height: 100px;
    background-color: rgba(255,255,255,0.95);
    box-shadow: 0 0.5rem 1rem rgba(0,0,0,0.05),inset 0 -1px 0 rgba(0,0,0,0.15);
}
.navbar-brand img {
    height: 75px;
}
.gallery_img {
    max-height: 275px;
}
.card-img, .card-img-top {
    border-top-left-radius: 10px;
    border-top-right-radius: 10px;
}
.card {
    border-top-left-radius: 10px;
    border-top-right-radius: 10px;
}
.hero-shadow
{
    position: relative;
    background-color: white;
}
.hero-image
{
    max-height: 600px;
    width: 100%;
    /*object-fit: none; */
    /*object-position: center; */
}
.hero-shadow:before, .hero-shadow:after
{
    z-index: -1;
    position: absolute;
    content: "";
    bottom: 15px;
    left: 10px;
    width: 50%;
    top: 80%;
    max-width:400px;
    background: #777;
    -webkit-box-shadow: 0 15px 10px #777;
    -moz-box-shadow: 0 15px 10px #777;
    box-shadow: 0 15px 10px #777;
    -webkit-transform: rotate(-3deg);
    -moz-transform: rotate(-3deg);
    -o-transform: rotate(-3deg);
    -ms-transform: rotate(-3deg);
    transform: rotate(-3deg);
}
.hero-shadow:after
{
    -webkit-transform: rotate(3deg);
    -moz-transform: rotate(3deg);
    -o-transform: rotate(3deg);
    -ms-transform: rotate(3deg);
    transform: rotate(3deg);
    right: 10px;
    left: auto;
}

</style>


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
            <div class="float-right">
                <select @change.prevent="filterLocation" v-model="filter_location_select"
                    class="mx-10 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 p-2.5">
                    <option value="filter_location-reset">Location</option>
                    <option v-for="(location, key) in locations_select" :value="'filter_location-' + key">
                        {{ location }}
                    </option>
                </select>
                <select
                    @change.prevent="sortLocation" v-model="sort_location_select"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 p-2.5">
                    <option value="sort_price-DESC">Price: High to Low</option>
                    <option value="sort_price-ASC">Price: Low to High</option>
                    <option value="sort_sqft-DESC">Sq ft: High to Low</option>
                    <option value="sort_sqft-ASC">Sq ft: Low to High</option>
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
