<template>
    <div class="bg-white rounded p-4">

        <div class="d-flex justify-content-between">
            <h3 class="mb-3 mt-3">List of client Journals</h3>
            <a :href="'/clients/' + client.id + '/journals/create'" class="btn btn-primary align-content-center">+ New Entry</a>
        </div>

        <template v-if="client.journals && client.journals.length > 0">
            <div v-for="(journal, index) in client.journals"
                 :key="'journal-' + index"
                 class="border-bottom pb-3 mb-3"
            >
                <div class="small font-weight-bold mb-3">{{journal.date}}</div>
                <div v-html="journal.entry"></div>
            </div>

        </template>

        <template v-else>
            <p class="text-center">There are journals.</p>
        </template>

    </div>
</template>

<script>
export default {
    name: 'JournalsList',

    props: {
        client: {
            type: Object
        }
    },
}
</script>

<style scoped>

</style>
