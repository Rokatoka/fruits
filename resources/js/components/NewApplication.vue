<template>
    <div class="modal fade" id="newApplicationModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">New Application</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Volume (kg)</label>
                            <div class="col-sm-10">
                                <input type="number" class="form-control" :class="{'is-invalid': errors.volume}" v-model="volume">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Fruit Type</label>
                            <div class="col-sm-10">
                                <select class="form-control" :class="{'is-invalid': errors.fruit_id}" v-model="fruit_id">
                                    <option value="0">Choose...</option>
                                    <option v-for="fruit in fruits" :value="fruit.id">{{fruit.name}}</option>
                                </select>
                            </div>
                        </div>
                    </form>
                    <div class="alert alert-danger" role="alert" v-if="no_boxes_error">
                        No boxes available
                    </div>
                    <div class="alert alert-success" role="alert" v-if="success">
                        Your fruits were placed in box {{box.name}}, the MAX volume is {{box.max_volume}},
                        was {{box.current_volume - volume}}, now {{box.current_volume}}
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" @click="makeApplication()">Save changes</button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>

    export default {
        props:['fruits', 'user_id'],
        data(){
            return{
                fruit_id: 0,
                volume: 0,
                no_boxes_error: false,
                success: false,
                box: null,
                errors: []
            }
        },

        methods:{
            makeApplication(){
                let _this = this;
                _this.box = null;
                _this.no_boxes_error = false;
                _this.success = false;
                _this.errors = [];
                let form = {
                    fruit_id: _this.fruit_id,
                    volume: _this.volume,
                    user_id: _this.user_id
                };
                axios.post('/api/fruit/apply', form).then((res) => {
                    if(res.data.message === 'no free box'){
                        _this.no_boxes_error = true;
                        _this.success = false;
                    }else{
                        _this.no_boxes_error = false;
                        _this.success = true;
                        _this.box = res.data.message;
                        _this.$emit('updated');
                    }

                }).catch((err) => {
                    _this.errors = err.response.data.message;
                })
            }
        }
    }
</script>
