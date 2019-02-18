<template>
    <div class="container">
        <div class="row">
            <div class="col-sm-12 mt-2">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">status</h3>

                        <div class="card-tools">
                            <button class="btn btn-success"
                                    @click="open_my_modal">
                                <!--data-toggle="modal" data-target="#create_status">-->
                                Add status <i
                                class="fa fa-user-plus fa-fw"></i></button>
                        </div>
                    </div>
                    <!-- /.box-header -->
                    <div class="card-body table-responsive no-padding">
                        <table class="table table-hover">
                            <tbody>
                            <tr>
                                <th>ID</th>
                                <th>Status Name</th>
                            </tr>
                            <tr v-for="status in status" :key="status.id">

                                <td>{{status.id}}</td>
                                <td>{{status.status_name}}</td>
                                <td>
                                    <button @click="edit_my_modal(status)">
                                        <i class="fa fa-edit blue"></i>
                                    </button>
                                    <button @click="delete_status(status.id)">
                                        <i class="fa fa-trash red"></i>
                                    </button>
                                </td>

                            </tr>

                            </tbody>
                        </table>
                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->
            </div>
        </div>
        <div class="modal fade in" id="create_status" role="dialog">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">


                    <div class="modal-body">
                        <!-- form start -->
                        <h5 v-show="!editMode" class="modal-title">Add New</h5>
                        <h5 v-show="editMode" class="modal-title">Update User's Information</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form @submit.prevent="editMode ? update_status():create_status()">
                        <div class="modal-body">
                            <div class="form-group">
                                <input v-model="form.status_name" type="text" name="status_name"
                                       placeholder="Pase Name (First Disburse)"
                                       class="form-control" :class="{ 'is-invalid': form.errors.has('status_name') }">
                                <has-error :form="form" field="status_name"></has-error>
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
                status: {},
                form: new Form({
                    id: '',
                    status_name: '',
                })
            }
        },
        methods: {
            update_status() {
                this.$Progress.start();

                this.form.put('api/status/' + this.form.id)
                    .then(() => {
                        Fire.$emit('StatusUpdated')
                        $('#create_status').modal('hide');
                        swal.fire(
                            'Updated',
                            'User Updated successfully',
                            'success',
                        )
                        this.$Progress.finish();

                    })
                    .catch(() => {
                        this.$Progress.fail();
                    })
            },
            delete_status(id) {
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

                        this.form.delete('api/status/' + id)
                            .then(() => {

                                swal.fire(
                                    'Deleted!',
                                    'The status has been deleted.',
                                    'success'
                                )
                                Fire.$emit("statusDeleted");
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
            create_status() {

                this.$Progress.start();

                this.form.post('api/status')
                    .then(() => {
                        Fire.$emit("statusCreated")

                        $('#create_status').modal('hide');

                        toast.fire({
                            type: 'success',
                            title: 'status Created successfully'
                        })
                        this.$Progress.finish()
                    })
                    .catch(() => {
                        this.$Progress.fail();
                    });


            }
            ,
            load_status() {
                axios.get('api/status').then(({data}) => (this.status = data.data));
            }
            ,
            open_my_modal() {
                this.editMode = false;
                this.form.reset();
                $("#create_status").modal('show');
            }, edit_my_modal(user) {
                this.editMode = true;
                console.log(user)
                this.form.reset();
                $("#create_status").modal('show');
                this.form.fill(user)
            }
        },
        mounted() {
            console.log('Component mounted.')
        }
        ,
        created() {
            this.load_status();
            Fire.$on("statusCreated", () => this.load_status());
            Fire.$on("statusDeleted", () => this.load_status());
            Fire.$on("StatusUpdated", () => this.load_status());
            // setInterval(() => this.load_status(), 10000);
        }
    }
</script>
