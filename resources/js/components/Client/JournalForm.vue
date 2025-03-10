<template>
    <div>
        <h1 class="mb-6">Add New Journal Entry for {{client.name}}</h1>

        <div class="border rounded bg-white">
            <textarea name="entry"
                      id="entry"
                      class="w-100 rounded p-3"
                      autofocus
                      rows="10"
                      v-model="entry"
            >

            </textarea>
        </div>
        <div class="d-flex justify-content-between mt-3">
            <button @click="storeJournal" class="btn btn-primary">Save</button>
            <a :href="'/clients/' + client.id" class="btn btn-default">Cancel</a>
        </div>
    </div>
</template>

<script>
import axios from "axios"

export default {
    name: 'JournalForm',
    props: {
        client: {
            type: Object
        },
    },

    data () {
        return {
            entry: null
        }
    },

    methods: {
        storeJournal () {
            axios.post('/clients/' + this.client.id + '/journals', {
                entry: this.entry
            })
                .then(response => {
                    window.location.href = '/clients/' + this.client.id
                })
        }
    }
}
</script>

<style scoped>

</style>
