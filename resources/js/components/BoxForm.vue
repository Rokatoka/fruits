<template>
    <div class="modal fade" id="newBoxModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">{{mode === 'create' ? 'New Box' : 'Edit Box'}}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Name</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" :class="{'is-invalid': errors.name}" v-model="form.name">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">MAX Volume (kg)</label>
                            <div class="col-sm-10">
                                <input type="number" class="form-control" :class="{'is-invalid': errors.max_volume}" v-model="form.max_volume">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Fruit Type</label>
                            <div class="col-sm-10">
                                <select class="form-control" :class="{'is-invalid': errors.fruit_id}" v-model="form.fruit_id">
                                    <option value="0">Choose...</option>
                                    <option v-for="fruit in fruits" :value="fruit.id">{{fruit.name}}</option>
                                </select>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" @click="saveBox()">Save changes</button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>

    export default {
        props:['fruits', 'mode', 'edit'],
        data(){
            return{
                form:{
                    name: '',
                    max_volume: 0,
                    fruit_id: 0,
                },
                errors:[]
            }
        },

        watch:{
            edit(val){
                if(val){
                    this.form = JSON.parse(JSON.stringify(val));
                }else{
                    this.form = {
                        name: '',
                        max_volume: 0,
                        fruit_id: 0
                    }
                }
            }
        },

        methods:{
            saveBox(){
                let _this = this;
                axios.post('/api/box/create', _this.form).then((res) => {
                    _this.form.name = '';
                    _this.form.max_volume = 0;
                    _this.form.fruit_id = 0;
                    _this.$emit('updated');
                    _this.errors = [];
                    $('#newBoxModal').modal('hide');

                }).catch((err) => {
                    _this.errors = err.response.data.message;
                })
            }
        }
    }
</script>
