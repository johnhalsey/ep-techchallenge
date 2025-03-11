<template>
    <div class="bg-white rounded p-4">

        <select name="bookingsFilter"
                id="bookingsFilter"
                class="border rounded p-1"
                v-model="bookingsFilter"
        >
            <option v-for="(option, index) in filterOptions"
                    :key="'filter-option-' + index"
                    :value="option.key">{{option.value}}</option>
        </select>

        <h3 class="mb-3 mt-3">List of client bookings</h3>

        <template v-if="filteredBookings && filteredBookings.length > 0">
            <table>
                <thead>
                <tr>
                    <th>Time</th>
                    <th>Notes</th>
                    <th>Actions</th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="booking in filteredBookings" :key="booking.id">
                    <td>{{booking.time_slot}}</td>
                    <td>{{ booking.notes }}</td>
                    <td>
                        <button class="btn btn-danger btn-sm" @click="deleteBooking(booking)">Delete</button>
                    </td>
                </tr>
                </tbody>
            </table>
        </template>

        <template v-else>
            <p class="text-center">The client has no bookings.</p>
        </template>

    </div>
</template>

<script>
import axios from "axios"

export default {
    name: 'BookingsList',

    props: {
        bookings: {
            type: Array
        }
    },

    data() {
        return {
            bookingsFilter: 'all',
            filterOptions: [
                {
                    key: 'past',
                    value: 'Past Bookings only'
                },
                {
                    key: 'all',
                    value: 'All bookings'
                },
                {
                    key: 'future',
                    value: 'Future Bookings only'
                },
            ]
        }
    },

    computed: {
        filteredBookings () {
            if (this.bookingsFilter == 'all') {
                return this.bookings
            }

            return this.bookings.filter(booking => booking.state == this.bookingsFilter)
        }
    },

    methods: {
        deleteBooking(booking) {
            axios.delete(`/bookings/${booking.id}`);
        }
    }
}
</script>

<style scoped>

</style>
