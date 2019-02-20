<template>
    <div class="container">
        <div class="row">
            <div class="col-sm-12 mt-2">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Readiness Types</h3>

                        <div class="card-tools">
                            <button class="btn btn-success"
                                    @click="open_my_modal">
                                <!--data-toggle="modal" data-target="#create_readiness_types">-->
                                Add Readiness Type <i
                                class="fa fa-ReadinessTypes-plus fa-fw"></i></button>
                        </div>
                    </div>
                    <!-- /.box-header -->
                    <div class="card-body table-responsive no-padding">
                        <table class="table table-hover">
                            <tbody>
                            <tr>
                                <th>ID</th>
                                <th>Readiness Name</th>
                            </tr>
                            <tr v-for="readiness_type in readiness_types.data" :key="readiness_type.id">

                                <td>{{readiness_type.id}}</td>
                                <td>{{readiness_type.readiness_type_name}}</td>
                                <td>
                                    <button @click="edit_my_modal(readiness_type)">
                                        <i class="fa fa-edit blue"></i>
                                    </button>
                                    <button @click="delete_readiness_types(readiness_type.id)">
                                        <i class="fa fa-trash red"></i>
                                    </button>
                                </td>

                            </tr>
                            <pagination :data="projects" @pagination-change-page="getResults"></pagination>


                            </tbody>
                        </table>
                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->
            </div>
        </div>
        <div class="modal fade in" id="create_readiness_types" role="dialog">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">


                    <div class="modal-body">
                        <!-- form start -->
                        <h5 v-show="!editMode" class="modal-title">Add New</h5>
                        <h5 v-show="editMode" class="modal-title">Update Readiness Types's Information</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form @submit.prevent="editMode ? update_readiness_types():create_readiness_types()">
                        <div class="modal-body">
                            <div class="form-group">
                                <input v-model="form.readiness_type_name" type="text" name="readiness_type_name"
                                       placeholder="Readiness Type Name ( eg NAP)"
                                       class="form-control" :class="{ 'is-invalid': form.errors.has('readiness_type_name') }">
                                <has-error :form="form" field="readiness_type_name"></has-error>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger pull-left" data-dismiss="modal">Close
                            </button>
                            <button v-show="!editMode" :disabled="form.busy" type="submit" class="btn btn-primary">
                                Create
                            </button>
                            <button v-show="editMode" :disabled="form.busy" type="submit" class="btn btn-success">
                                Update
                            </button>
                        </div>
                    </form>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>

    </div>

</template>

<script>
    export default {
        data() {
            return {
                editMode: false,
                readiness_types: {},
                form: new Form({
                    id: '',
                    readiness_type_name: '',
                })
            }
        },
        methods: {
            getResults(page = 1) {
                axios.get('api/readiness_type?page=' + page)
                    .then(response => {
                        this.readiness_types = response.data;
                    });
            },
            update_readiness_types() {
                this.$Progress.start();

                this.form.put('api/readiness_type/' + this.form.id)
                    .then(() => {
                        Fire.$emit('ReadinessTypesUpdated')
                        $('#create_readiness_types').modal('hide');
                        swal.fire(
                            'Updated',
                            'Readiness Types Updated successfully',
                            'success',
                        )
                        this.$Progress.finish();

                    })
                    .catch(() => {
                        this.$Progress.fail();
                    })
            },
            delete_readiness_types(id) {
                swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.value) {
                        this.$Progress.start();

                        this.form.delete('api/readiness_type/' + id)
                            .then(() => {

                                swal.fire(
                                    'Deleted!',
                                    'The Readiness Type has been deleted.',
                                    'success'
                                )
                                Fire.$emit("PhaseDeleted");
                                this.$Progress.finish();


                            })
                            .catch(() => {
                                swal.fire(
                                    'Opps',
                                    'Something Went Wrong :)',
                                    'error'
                                )
                                this.$Progress.fail();

                            })

                    }
                })


            },
            create_readiness_types() {

                this.$Progress.start();

                this.form.post('api/readiness_type')
                    .then(() => {
                        Fire.$emit("ReadinessTypeCreated")

                        $('#create_readiness_types').modal('hide');

                        toast.fire({
                            type: 'success',
                            title: 'Readiness Type Created successfully'
                        })
                        this.$Progress.finish()
                    })
                    .catch(() => {
                        this.$Progress.fail();
                    });


            }
            ,
            load_readiness_types() {
                axios.get('api/readiness_type').then(({data}) => (this.readiness_types = data));
            }
            ,
            open_my_modal() {
                this.editMode = false;
                this.form.reset();
                $("#create_readiness_types").modal('show');
            }, edit_my_modal(ReadinessTypes) {
                this.editMode = true;
                console.log(ReadinessTypes)
                this.form.reset();
                $("#create_readiness_types").modal('show');
                this.form.fill(ReadinessTypes)
            }
        },
        mounted() {
            console.log('Component mounted.')
        }
        ,
        created() {
            this.load_readiness_types();
            Fire.$on("ReadinessTypeCreated", () => this.load_readiness_types());
            Fire.$on("ReadinessTypeDeleted", () => this.load_readiness_types());
            Fire.$on("ReadinessTypesUpdated", () => this.load_readiness_types());
            // setInterval(() => this.load_Readiness Types(), 10000);
        }
    }
</script>
