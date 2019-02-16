<template>
    <div class="container">
        <div class="row">
            <div class="col-sm-12 mt-2">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Phases</h3>

                        <div class="card-tools">
                            <button class="btn btn-success"
                                    @click="open_my_modal">
                                <!--data-toggle="modal" data-target="#create_phase">-->
                                Add Phase <i
                                class="fa fa-user-plus fa-fw"></i></button>
                        </div>
                    </div>
                    <!-- /.box-header -->
                    <div class="card-body table-responsive no-padding">
                        <table class="table table-hover">
                            <tbody>
                            <tr>
                                <th>ID</th>
                                <th>Phase Name</th>
                            </tr>
                            <tr v-for="phase in phases" :key="phase.id">

                                <td>{{phase.id}}</td>
                                <td>{{phase.phase_name}}</td>
                                <td>
                                    <button @click="edit_my_modal(phase)">
                                        <i class="fa fa-edit blue"></i>
                                    </button>
                                    <button @click="delete_phase(phase.id)">
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
        <div class="modal fade in" id="create_phase" role="dialog">
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
                    <form @submit.prevent="editMode ? update_phase():create_phase()">
                        <div class="modal-body">
                            <div class="form-group">
                                <input v-model="form.phase_name" type="text" name="phase_name"
                                       placeholder="Pase Name (First Disburse)"
                                       class="form-control" :class="{ 'is-invalid': form.errors.has('phase_name') }">
                                <has-error :form="form" field="phase_name"></has-error>
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
                phases: {},
                form: new Form({
                    id: '',
                    phase_name: '',
                })
            }
        },
        methods: {
            update_phase() {
                this.$Progress.start();

                this.form.put('api/phase/' + this.form.id)
                    .then(() => {
                        Fire.$emit('PhaseUpdated')
                        $('#create_phase').modal('hide');
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
            delete_phase(id) {
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

                        this.form.delete('api/phase/' + id)
                            .then(() => {

                                swal.fire(
                                    'Deleted!',
                                    'The Phase has been deleted.',
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
            create_phase() {

                this.$Progress.start();

                this.form.post('api/phase')
                    .then(() => {
                        Fire.$emit("PhaseCreated")

                        $('#create_phase').modal('hide');

                        toast.fire({
                            type: 'success',
                            title: 'Phase Created successfully'
                        })
                        this.$Progress.finish()
                    })
                    .catch(() => {
                        this.$Progress.fail();
                    });


            }
            ,
            load_phases() {
                axios.get('api/phase').then(({data}) => (this.phases = data.data));
            }
            ,
            open_my_modal() {
                this.editMode = false;
                this.form.reset();
                $("#create_phase").modal('show');
            }, edit_my_modal(user) {
                this.editMode = true;
                console.log(user)
                this.form.reset();
                $("#create_phase").modal('show');
                this.form.fill(user)
            }
        },
        mounted() {
            console.log('Component mounted.')
        }
        ,
        created() {
            this.load_phases();
            Fire.$on("PhaseCreated", () => this.load_phases());
            Fire.$on("PhaseDeleted", () => this.load_phases());
            Fire.$on("PhaseUpdated", () => this.load_phases());
            // setInterval(() => this.load_phases(), 10000);
        }
    }
</script>
