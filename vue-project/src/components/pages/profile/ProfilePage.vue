<template>
    <div class="page">
        <div class="main-container">
            <div class="main-card">
                <p>name: {{ this.user.name }}</p>
                <p>email: {{ this.user.email }}</p>
                <div class="form-group">
                    <label for="exampleFormControlSelect1">Выберите модель</label>
                    <select v-model="selectedModel" class="form-control mt-3" id="exampleFormControlSelect1">
                        <option v-for="(value, key) in modelsList" :key="key" :value="key">{{ value.name }}</option>
                    </select>
                </div>

                <button @click.prevent="selectNewModel" type="button" class="btn btn-outline-success mt-3">Изменить модель</button>
                <button @click.prevent="logout" type="button" class="btn btn-outline-danger mt-3 ms-3">Выход</button>
            </div>
        </div>
    </div>
</template>
<script>
export default {
    data() {
        return {
            modelsList: [],
            selectedModel: null,

            user: {
                name: null,
                email: null
            }
        }
    },

    mounted() {
        this.getModels();
        this.getUser();
    },

    methods: {
        getUser() {
            this.$axios.get('/api/user').then(res => {
                console.log(res);
                this.user.name = res.data.name;
                this.user.email = res.data.email;
            })
        },

        getModels() {
            this.$axios.get('/api/profile/modelslist').then(res => {
                this.modelsList = res.data;

                for(let i = 0; i < this.modelsList.length; i++) {
                    if (this.modelsList[i].isSelected) {
                        this.selectedModel = i;
                        break;
                    }
                }

                console.log(this.modelsList);
            });
        },

        selectNewModel() {
            this.$axios.post('/api/profile/setmodel', {
                'newModelName': this.modelsList[this.selectedModel].name,
            }).then(res => {
                console.log(res);
            });
        },

        logout() {
            if (localStorage.getItem('auth') === 'true') {
                this.$axios.post('/api/auth/logout').then(() => {
                    localStorage.removeItem('auth');
                    this.$router.push({ name: 'auth' });
                });
            }
        },
    },
}
</script>
<style>
.container {
    display: flex;
    justify-content: center;
    align-items: center;
    min-height: 100vh;
    flex-direction: column;
}
</style>