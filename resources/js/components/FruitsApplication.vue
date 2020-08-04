<template>
    <div class="container">
        <ul class="list-group">
            <li class="list-group-item">
                <button type="button" class="btn btn-primary" @click="newApplication()">
                    New Application
                </button>
            </li>
            <li class="list-group-item">
                <table class="table">
                    <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Name</th>
                        <th scope="col">MAX Volume</th>
                        <th scope="col">Current Volume</th>
                        <th scope="col">Fruit</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="(box, index) in boxes">
                        <th scope="row">{{index + 1}}</th>
                        <td>{{box.name}}</td>
                        <td>{{box.max_volume}}</td>
                        <td>{{box.current_volume}}</td>
                        <td>{{box.fruit.name}}</td>
                    </tr>
                    </tbody>
                </table>
            </li>
        </ul>
        <new-application :fruits="fruits" :user_id="user_id" @updated="getUserBoxes"></new-application>
    </div>
</template>

<script>
    import NewApplication from './NewApplication'

    export default {
        components:{
            NewApplication
        },

        data(){
            return{
                fruits:[],
                boxes:[],
                user_id: JSON.parse(localStorage.getItem('user')).id
            }
        },

        methods:{
            newApplication(){
                $('#newApplicationModal').modal();
            },

            getFruits(){
                let _this = this;
                axios.get('/api/fruits', {}).then((res) => {
                    _this.fruits = res.data.data;
                }).catch((err) => {
                    console.log(err)
                })
            },

            getUserBoxes(){
                let _this = this;
                axios.get(`/api/boxes/${_this.user_id}`, {}).then((res) => {
                    _this.boxes = res.data.data;
                }).catch((err) => {
                    console.log(err)
                })
            }
        },

        mounted() {
            this.getUserBoxes();
            this.getFruits();
        }
    }
</script>
