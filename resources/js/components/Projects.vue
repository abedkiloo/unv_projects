<template>
    <div class="container">
        <div class="row">
            <div class="col-sm-12 mt-2">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Projects Table</h3>

                        <div class="card-tools">
                            <button class="btn btn-success"
                                    @click="open_my_modal">
                                <!--data-toggle="modal" data-target="#create_project">-->

                                Add Project <i
                                class="fa fa-user-plus fa-fw"></i></button>
                        </div>
                    </div>
                    <!-- /.box-header -->
                    <div class="card-body table-responsive no-padding">
                        <table class="table table-hover">
                            <tbody>
                            <tr>
                                <th>ID</th>
                                <th>Project Ref</th>
                                <th>Country</th>
                                <th>Implementing Office</th>
                                <th>Project Title</th>
                                <th>Grant amount (USD)</th>
                                <th>Date Of GCF</th>
                                <th>Duration (months)</th>
                                <th>Duration</th>
                                <th>End Date</th>
                                <th>Readiness or NAP</th>
                                <th>Type of readiness</th>
                                <th>Status</th>
                                <th>Modify</th>
                            </tr>
                            <tr v-for="project in projects.data" :key="project.id">

                                <td>{{project.id}}</td>
                                <td>{{project.project_ref}}</td>
                                <td>{{project.project_title}}</td>
                                <td>{{project.date_of_gcf | custom_date}}</td>
                                <td>{{project.start_date | custom_date}}</td>
                                <td>{{project.duration}}</td>
                                <td>{{project.end_date | custom_date}}</td>
                                <td>{{project.disbursement_id}}</td>
                                <td>{{project.readiness_id }}</td>
                                <td>{{project.readiness_or_nap }}</td>
                                <td>
                                    <button @click="edit_my_modal(project)">
                                        <i class="fa fa-edit blue"></i>
                                    </button>
                                    <button @click="delete_project(project.id)">
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
        <div class="modal fade in" id="create_project" role="dialog">
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
                    <form @submit.prevent="editMode ? update_project():create_project()">
                        <div class="modal-body">
                            <div class="form-group">
                                <input v-model="form.project_ref" type="text" name="project_ref"
                                       placeholder="Project Ref"
                                       class="form-control" :class="{ 'is-invalid': form.errors.has('project_ref') }">
                                <has-error :form="form" field="project_ref"></has-error>
                            </div>

                            <div class="form-group">
                                <input v-model="form.project_title" type="text" name="project_title"
                                       placeholder="Project Title"
                                       class="form-control" :class="{ 'is-invalid': form.errors.has('project_title') }">
                                <has-error :form="form" field="project_title"></has-error>
                            </div>

                            <div class="form-group">
                                <input v-model="form.date_of_gcf" type="text" name="date_of_gcf"
                                       placeholder="Date Of GCF"
                                       class="form-control" :class="{ 'is-invalid': form.errors.has('date_of_gcf') }">
                                <has-error :form="form" field="date_of_gcf"></has-error>
                            </div>

                            <div class="form-group">
                                <input v-model="form.start_date" type="text" name="start_date"
                                       placeholder="Start Date"
                                       class="form-control" :class="{ 'is-invalid': form.errors.has('start_date') }">
                                <has-error :form="form" field="start_date"></has-error>
                            </div>

                            <div class="form-group">
                                <input v-model="form.end_date" type="text" name="end_date"
                                       placeholder="End Date"
                                       class="form-control" :class="{ 'is-invalid': form.errors.has('end_date') }">
                                <has-error :form="form" field="end_date"></has-error>
                            </div>

                            <div class="form-group">
                                <input v-model="form.duration" type="text" name="duration"
                                       placeholder="Duration"
                                       class="form-control" :class="{ 'is-invalid': form.errors.has('duration') }">
                                <has-error :form="form" field="duration"></has-error>
                            </div>

                            <div class="form-group">
                                <select name="type" v-model="form.disbursement_id" id="type" class="form-control"
                                        :class="{ 'is-invalid': form.errors.has('disbursement_id') }">
                                    <option value="">Select User Role</option>
                                    <option value="1">Admin</option>
                                    <option value="2">Standard User</option>
                                    <option value="3">Author</option>
                                </select>
                                <has-error :form="form" field="disbursement_id"></has-error>
                            </div>

                            <div class="form-group">
                                <input v-show="!editMode" v-model="form.password" type="password" name="password"
                                       id="password"
                                       class="form-control" :class="{ 'is-invalid': form.errors.has('password') }">
                                <has-error :form="form" field="password"></has-error>
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
                projects: {},
                form: new Form({
                    id: '',
                    project_ref: '',
                    project_title: '',
                    date_of_gcf: '',
                    start_date: '',
                    duration: '',
                    end_date: '',
                    disbursement_id: '',
                    readiness_id: '',
                    readiness_of_nap: '',
                    status_id: ''
                })
            }
        },
        methods: {
            getResults(page = 1) {
                axios.get('api/project?page=' + page)
                    .then(response => {
                        this.projects = response.data;
                    });
            },
            update_project() {
                this.$Progress.start();

                this.form.put('api/project/' + this.form.id)
                    .then(() => {
                        Fire.$emit('ProjectUpdated')
                        $('#create_project').modal('hide');
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
            delete_project(id) {
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

                        this.form.delete('api/project/' + id)
                            .then(() => {

                                swal.fire(
                                    'Deleted!',
                                    'The User has been deleted.',
                                    'success'
                                )
                                Fire.$emit("ProjectDeleted");
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
            create_project() {

                this.$Progress.start();

                this.form.post('api/project')
                    .then(() => {
                        Fire.$emit("ProjectCreated")

                        $('#create_project').modal('hide');

                        toast.fire({
                            type: 'success',
                            title: 'User Created successfully'
                        })
                        this.$Progress.finish()
                    })
                    .catch(() => {
                        this.$Progress.fail();
                    });


            }
            ,
            load_projects() {
                axios.get('api/project').then(({data}) => (this.projects = data));
            }
            ,
            open_my_modal() {
                this.editMode = false;
                this.form.reset();
                $("#create_project").modal('show');
            }, edit_my_modal(user) {
                this.editMode = true;
                console.log(user)
                this.form.reset();
                $("#create_project").modal('show');
                this.form.fill(user)
            }
        },
        mounted() {
            console.log('Component mounted.')
        }
        ,
        created() {
            this.load_projects();
            Fire.$on("ProjectCreated", () => this.load_projects());
            Fire.$on("ProjectDeleted", () => this.load_projects());
            Fire.$on("ProjectUpdated", () => this.load_projects());
            // setInterval(() => this.load_projects(), 10000);
        }
    }
</script>
