<template>
    <div class="page">
        <div class="main-container">
            <div class="main-card">
                <h2 class="mb-4">Create interview</h2>
                <form>
                    <div class="mb-3">
                        <label for="title" class="form-label">Name</label>
                        <input v-model="name" type="text" class="form-control" id="title" placeholder="Enter name"
                            required>
                    </div>
                    <div class="mb-3">
                        <label for="file" class="form-label">Load .txt file with questions</label>
                        <input type="file" class="form-control" id="file" accept=".txt" @change="handleFileUpload"
                            required>
                    </div>
                    <button @click.prevent="create" type="submit" class="btn btn-primary">Create</button>
                </form>
            </div>

            <div v-if="interviewToken" class="link-card">
                <p>Your interview link:</p>
                <div class="link-container">
                    <input type="text" :value="fullInterviewLink" class="form-control" readonly>
                    <button @click="copyLink" class="btn btn-secondary">Copy</button>
                </div>
                <p v-if="copySuccess" class="copy-success">Link copied!</p>
            </div>
        </div>
    </div>
</template>
<script>
export default {
    data() {
        return {
            name: null,
            questionsFile: null,
            interviewToken: null,
            url: null,
            copySuccess: false
        }
    },

    computed: {
        fullInterviewLink() {
            return this.url + '/interview/' + this.interviewToken;
        }
    },

    mounted() {
        this.url = window.location.origin;
        console.log(this.url);
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
        },

        copyLink() {
            navigator.clipboard.writeText(this.fullInterviewLink).then(() => {
                this.copySuccess = true;
                setTimeout(() => this.copySuccess = false, 2000);
            });
        },
    },
}
</script>
<style scoped>
.link-card {
    margin-top: 20px;
    background-color: #2c2c2c;
    padding: 15px;
    border-radius: 8px;
    text-align: center;
    width: 100%;
    max-width: 500px;
}

.link-card p {
    margin: 0 0 10px;
    font-size: 16px;
    color: #e0e0e0;
}

.link-container {
    display: flex;
    gap: 10px;
}

.link-container input {
    flex-grow: 1;
    background-color: #3a3a3a;
    color: #fff;
    border: none;
    padding: 8px;
    border-radius: 5px;
}

</style>