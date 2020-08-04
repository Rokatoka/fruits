<template>
    <div class="container">
        <ul class="list-group">
            <li class="list-group-item">
                <button type="button" class="btn btn-primary" @click="createBox()">
                    Add Box
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
                        <th scope="col"></th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="(box, index) in boxes">
                        <th scope="row">{{index + 1}}</th>
                        <td>{{box.name}}</td>
                        <td>{{box.max_volume}}</td>
                        <td>{{box.current_volume}}</td>
                        <td>{{box.fruit.name}}</td>
                        <td>
                            <button class="btn btn-danger" @click="deleteBox(box.id)">
                                <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-trash" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z"></path>
                                    <path fill-rule="evenodd" d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4L4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z"></path>
                                </svg>
                            </button>
                           <button class="btn btn-primary" @click="editBox(box)">
                               <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-pen" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                   <path fill-rule="evenodd" d="M5.707 13.707a1 1 0 0 1-.39.242l-3 1a1 1 0 0 1-1.266-1.265l1-3a1 1 0 0 1 .242-.391L10.086 2.5a2 2 0 0 1 2.828 0l.586.586a2 2 0 0 1 0 2.828l-7.793 7.793zM3 11l7.793-7.793a1 1 0 0 1 1.414 0l.586.586a1 1 0 0 1 0 1.414L5 13l-3 1 1-3z"/>
                                   <path fill-rule="evenodd" d="M9.854 2.56a.5.5 0 0 0-.708 0L5.854 5.855a.5.5 0 0 1-.708-.708L8.44 1.854a1.5 1.5 0 0 1 2.122 0l.293.292a.5.5 0 0 1-.707.708l-.293-.293z"/>
                                   <path d="M13.293 1.207a1 1 0 0 1 1.414 0l.03.03a1 1 0 0 1 .03 1.383L13.5 4 12 2.5l1.293-1.293z"/>
                               </svg>
                           </button>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </li>
            <li class="list-group-item d-flex justify-content-center" v-if="page !== last_page">
                <ul class="pagination">
                    <li class="page-item">
                        <button class="page-link"
                           @click="getBoxes">
                            More
                        </button>
                    </li>
                </ul>
            </li>
        </ul>
        <box-form :fruits="fruits"
                  :mode="mode"
                  :edit="edit"
                  @updated="updated()"></box-form>
    </div>
</template>

<script>

    import BoxForm from './BoxForm'

    export default {
        components:{
            BoxForm
        },

        data(){
            return {
                boxes: [],
                fruits:[],
                page: 1,
                last_page: 0,
                has_next: false,
                edit: null,
                mode: 'create'
            }
        },

        methods:{
            getBoxes(){
                let _this = this;
                _this.page = _this.has_next ? _this.page + 1 : _this.page;
                let data = {
                    page: _this.page
                };
                axios.get('/api/boxes', {params: data}).then((res) => {
                    _this.boxes = _this.boxes.concat(res.data.data.data);
                    _this.has_next = res.data.data.next_page_url;
                    _this.last_page = res.data.data.last_page;
                }).catch((err) => {
                    console.log(err)
                })
            },

            getFruits(){
                let _this = this;
                axios.get('/api/fruits', {}).then((res) => {
                    _this.fruits = res.data.data;
                }).catch((err) => {
                    console.log(err)
                })
            },

            updated(){
                this.page = 1;
                this.has_next = false;
                this.last_page = 0;
                this.boxes = [];
                this.getBoxes()
            },

            deleteBox(id){
                axios.delete(`/api/box/${id}`, {}).then(() => {
                    this.updated();
                }).catch((err) => {
                    console.log(err)
                })
            },

            editBox(box){
                this.edit = box;
                this.mode = 'edit'
                $('#newBoxModal').modal();
            },

            createBox(){
                this.edit = null;
                this.mode = 'create'
                $('#newBoxModal').modal();
            }
        },

        mounted() {
            this.getBoxes();
            this.getFruits();
        }
    }
</script>
