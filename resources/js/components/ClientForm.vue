<template>
    <div>
        <h1 class="mb-6">Clients -> Add New Client</h1>

        <div class="max-w-lg mx-auto">
            <div class="form-group">
                <label for="name">Name</label>
                <input type="text" id="name" class="form-control" v-model="client.name">
                <div v-if="errorBagHas('name')" class="text-red-500">{{errorBagValue('name')}}</div>
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="text" id="email" class="form-control" v-model="client.email">
                <div v-if="errorBagHas('email')" class="text-red-500">{{errorBagValue('email')}}</div>
            </div>
            <div class="form-group">
                <label for="phone">Phone</label>
                <input type="text" id="phone" class="form-control" v-model="client.phone">
                <div v-if="errorBagHas('phone')" class="text-red-500">{{errorBagValue('phone')}}</div>
            </div>
            <div class="form-group">
                <label for="name">Address</label>
                <input type="text" id="address" class="form-control" v-model="client.address">
            </div>
            <div class="flex">
                <div class="form-group flex-1">
                    <label for="city">City</label>
                    <input type="text" id="city" class="form-control" v-model="client.city">
                </div>
                <div class="form-group flex-1">
                    <label for="postcode">Postcode</label>
                    <input type="text" id="postcode" class="form-control" v-model="client.postcode">
                </div>
            </div>

            <div class="text-right">
                <a href="/clients" class="btn btn-default">Cancel</a>
                <button @click="storeClient" class="btn btn-primary">Create</button>
            </div>
        </div>
    </div>
</template>

<script>
import axios from 'axios';

export default {
    name: 'ClientForm',

    data() {
        return {
            client: {
                name: '',
                email: '',
                phone: '',
                address: '',
                city: '',
                postcode: '',
            },
            errorBag: []
        }
    },

    methods: {
        storeClient() {
            this.errorBag = []
            const headers = {
                'Content-Type': 'application/json',
            }
            axios.post('/clients', this.client, {
                headers
            })
                .then(response => {
                    window.location.href = response.data.url;
                })
                .catch((error) => {
                    for (let key in error.response.data.errors) {
                        this.errorBag.push({
                            key: key,
                            value: error.response.data.errors[key][0]
                        })
                    }
                })
        },
        errorBagHas(key) {
            if (this.errorBag.find(error => error.key == key)) {
                return true
            }

            return false
        },
        errorBagValue(key) {
            return this.errorBag.find(error => error.key == key).value
        }
    }
}
</script>
