<template>
    <div>
        <h1 class="mb-6">Clients -> {{ client.name }}</h1>

        <div class="flex">
            <div class="w-1/3 mr-5">
                <div class="w-full bg-white rounded p-4">
                    <h2>Client Info</h2>
                    <table>
                        <tbody>
                            <tr>
                                <th class="text-gray-600 pr-3">Name</th>
                                <td>{{ client.name }}</td>
                            </tr>
                            <tr>
                                <th class="text-gray-600 pr-3">Email</th>
                                <td>{{ client.email }}</td>
                            </tr>
                            <tr>
                                <th class="text-gray-600 pr-3">Phone</th>
                                <td>{{ client.phone }}</td>
                            </tr>
                            <tr>
                                <th class="text-gray-600 pr-3">Address</th>
                                <td>{{ client.address }}<br/>{{ client.postcode + ' ' + client.city }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="w-2/3">
                <div>
                    <button class="btn" :class="{'btn-primary': currentTab == 'bookings', 'btn-default': currentTab != 'bookings'}" @click="switchTab('bookings')">Bookings</button>
                    <button class="btn" :class="{'btn-primary': currentTab == 'journals', 'btn-default': currentTab != 'journals'}" @click="switchTab('journals')">Journals</button>
                </div>

                <bookings-list v-if="currentTab == 'bookings'"
                               :bookings="client.bookings">
                </bookings-list>
                <journals-list v-if="currentTab == 'journals'"
                               :client="client"
                >
                </journals-list>

            </div>
        </div>
    </div>
</template>

<script>
import axios from 'axios';
import BookingsList from "./Client/BookingsList.vue"
import JournalsList from "./Client/JournalsList.vue"

export default {
    name: 'ClientShow',
    components: {
        BookingsList,
        JournalsList
    },

    props: ['client'],

    data() {
        return {
            currentTab: 'bookings',
        }
    },

    methods: {
        switchTab(newTab) {
            this.currentTab = newTab;
        },

    }
}
</script>
