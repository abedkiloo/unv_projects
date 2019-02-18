<template>
    <div class="container">
        <div class="row">
            <div class="col-sm-12 mt-2">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Disbursement Table</h3>

                        <div class="card-tools">
                            <button class="btn btn-success"
                                    @click="open_my_modal">
                                <!--data-toggle="modal" data-target="#create_disburse">-->

                                Add Disburse <i
                                class="fa fa-user-plus fa-fw"></i></button>
                        </div>
                    </div>
                    <!-- /.box-header -->
                    <div class="card-body table-responsive no-padding">
                        <table class="table table-hover">
                            <tbody>
                            <tr>
                                <th>ID</th>
                                <th>Project Name</th>
                                <th>Phase</th>
                                <th>Amount</th>
                                <th>Released At</th>
                                <th>Modify</th>
                            </tr>
                            <tr v-for="disburse in disbursements" :key="disburse.id">

                                <td>{{disburse.id}}</td>
                                <td>{{disburse.projects.project_title}}</td>
                                <td>{{disburse.phase_id.phase_name}}</td>
                                <td>{{disburse.project_id}}</td>
                                <td>{{disburse.amount}}</td>
                                <td>
                                    <button @click="edit_my_modal(disburse)">
                                        <i class="fa fa-edit blue"></i>
                                    </button>
                                    <button @click="delete_disburse(disburse.id)">
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
        <div class="modal fade in" id="create_disburse" role="dialog">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">


                    <div class="modal-body">
                        <!-- form start -->
                        <h5 v-show="!editMode" class="modal-title">Add Disburse</h5>
                        <h5 v-show="editMode" class="modal-title">Update Disburse's Information</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form @submit.prevent="editMode ? update_disburse():create_disburse()">
                        <div class="modal-body">
                            <div class="form-group">
                                <input v-model="form.amount" type="text" name="amount"
                                       placeholder="Amount"
                                       class="form-control" :class="{ 'is-invalid': form.errors.has('amount') }">
                                <has-error :form="form" field="amount"></has-error>
                            </div>

                            <div class="form-group">
                                <select name="type" v-model="form.phase_id" id="phase_id"
                                        class="form-control"
                                        :class="{ 'is-invalid': form.errors.has('phase_id') }">
                                    <option value="">Select Phase</option>
                                    <option v-for="phase in phases" :value="phase.id">{{phase.phase_name}}</option>
                                </select>
                                <has-error :form="form" field="phase_id"></has-error>
                            </div>
                            <div class="form-group">
                                <select name="type" v-model="form.project_id" id="type" class="form-control"
                                        :class="{ 'is-invalid': form.errors.has('project_id') }">
                                    <option value="">Select Project</option>
                                    <option v-for="project in projects" :value="project.id">{{project.project_title}}
                                    </option>
                                </select>
                                <has-error :form="form" field="project_id"></has-error>
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
                phases: {},
                editMode: false,
                projects: {},
                disbursements: {},
                form: new Form({
                    id: '',
                    amount: '',
                    phase_id: '',
                    project_id: '',
                })
            }
        },
        methods: {

            load_phases() {
                axios.get('api/phase').then(({data}) => (this.phases = data.data));
            },
            update_disburse() {
                this.$Progress.start();

                this.form.put('api/disburse/' + this.form.id)
                    .then(() => {
                        Fire.$emit('DisburseUpdated')
                        $('#create_disburse').modal('hide');
                        swal.fire(
                            'Updated',
                            'Disburse Updated successfully',
                            'success',
                        )
                        this.$Progress.finish();

                    })
                    .catch(() => {
                        this.$Progress.fail();
                    })
            },
            delete_disburse(id) {
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

                        this.form.delete('api/disburse/' + id)
                            .then(() => {

                                swal.fire(
                                    'Deleted!',
                                    'The Disburse has been deleted.',
                                    'success'
                                )
                                Fire.$emit("DisburseDeleted");
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
            create_disburse() {

                this.$Progress.start();

                this.form.post('api/disburse')
                    .then(() => {
                        Fire.$emit("DisburseCreated")

                        $('#create_disburse').modal('hide');

                        toast.fire({
                            type: 'success',
                            title: 'Disburse Created successfully'
                        })
                        this.$Progress.finish()
                    })
                    .catch(() => {
                        this.$Progress.fail();
                    });


            }
            ,
            load_disburse() {
                axios.get('api/disburse').then(({data}) => (this.disbursements = data.data));
            }
            , load_projects() {
                axios.get('api/project').then(({data}) => (this.projects = data.data));
            }
            ,
            open_my_modal() {
                this.editMode = false;
                this.form.reset();
                $("#create_disburse").modal('show');
            }, edit_my_modal(user) {
                this.editMode = true;
                console.log(user)
                this.form.reset();
                $("#create_disburse").modal('show');
                this.form.fill(user)
            }
        },
        mounted() {
            console.log('Component mounted.')
        }
        ,
        created() {
            this.load_phases();
            this.load_disburse();
            this.load_projects();
            Fire.$on("DisburseCreated", () => this.load_disburse());
            Fire.$on("DisburseDeleted", () => this.load_disburse());
            Fire.$on("DisburseUpdated", () => this.load_disburse());
            // setInterval(() => this.load_users(), 10000);
        }
    }
</script>
