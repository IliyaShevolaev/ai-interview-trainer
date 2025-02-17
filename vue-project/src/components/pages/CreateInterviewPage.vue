<template>
    <div>
        <h2 class="mb-4">Create interview</h2>
        <form>
            <div class="mb-3">
                <label for="title" class="form-label">Name</label>
                <input v-model="name" type="text" class="form-control" id="title" placeholder="Enter name" required>
            </div>
            <div class="mb-3">
                <label for="file" class="form-label">Load .txt file with questions</label>
                <input type="file" class="form-control" id="file" accept=".txt" @change="handleFileUpload" required>
            </div>
            <button @click.prevent="create" type="submit" class="btn btn-primary">Create</button>
        </form>

        <p v-if="interviewToken">You interview token: {{ this.interviewToken }}</p>
    </div>
</template>
<script>
export default {
    data() {
        return {
            name: null,
            questionsFile: null,
            interviewToken: null
        }
    },

    methods: {
        handleFileUpload(event) {
            this.questionsFile = event.target.files[0];
        },

        create() {
            let formData = new FormData();
            formData.append("title", this.name);
            formData.append("questions_file", this.questionsFile);

            this.$axios.post("/api/interview/store", formData).then(res => {
                this.interviewToken = res.data.token;
                console.log(res);
            })
        }
    },
}
</script>
<style></style>