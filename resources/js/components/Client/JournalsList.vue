<template>
    <div class="bg-white rounded p-4">

        <div class="d-flex justify-content-between">
            <h3 class="mb-3 mt-3">List of client Journals</h3>
            <a :href="'/clients/' + client.id + '/journals/create'" class="btn btn-primary align-content-center">+ New Entry</a>
        </div>

        <div v-if="client.journals && client.journals.length > 0" class="mt-3">
            <div v-for="(journal, index) in client.journals"
                 :key="'journal-' + index"
                 class="border-bottom pb-3 mb-3"
            >
                <div class="d-flex justify-content-between">
                    <div class="small font-weight-bold mb-3">{{journal.date}}</div>
                    <div>
                        <button class="btn btn-danger btn-sm" @click="deleteJournal(journal)">Delete</button>
                    </div>
                </div>

                <div v-html="journal.entry"></div>
            </div>

        </div>

        <template v-else>
            <p class="text-center">There are journals.</p>
        </template>

    </div>
</template>

<script>
import axios from "axios"

export default {
    name: 'JournalsList',

    props: {
        client: {
            type: Object
        }
    },

    methods: {
        deleteJournal (journal) {
            axios.delete('/clients/' + this.client.id + '/journals/' + journal.id)
                .then(() => {
                    location.reload();
                })
        }
    }
}
</script>

<style scoped>

</style>
