
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
                                class="fa fa-plus-square-o fa-fw"></i></button>
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
                                <th>Start Date</th>
                                <th>End Date</th>
                                <th>Readiness or NAP</th>
                                <th>Type of readiness</th>
                                <th>Status</th>
                                <th>Modify</th>
                            </tr>
                            <tr v-for="project in projects.data" :key="project.id">

                                <td>{{project.id}}</td>
                                <td>{{project.project_ref}}</td>
                                <td>{{project.project_country.country_name}}</td>
                                <td>{{project.implementing_office}}</td>
                                <td>{{project.project_title}}</td>
                                <td>{{project.amount }}</td>
                                <td>{{project.date_of_gcf }}</td>
                                <td>{{project.duration}}</td>
                                <td>{{project.start_date }}</td>
                                <td>{{project.end_date }}</td>
                                <td>{{project.readiness_or_nap | ready_nap}}</td>
                                <td>{{project.project_status.status_name }}</td>
                                <td>
                                    <button @click="edit_my_modal(project)">
                                        <i class="fa fa-edit blue"></i>
                                    </button>
                                    <button @click="delete_project(project.id)">
                                        <i class="fa fa-trash red"></i>
                                    </button>
                                </td>

                            </tr>


                            </tbody>
                        </table>
                    </div>
                    <!-- /.card-body -->
                </div>
                <pagination :data="projects" @pagination-change-page="getResults"></pagination>

                <!-- /.card -->
            </div>
        </div>
        <div class="modal fade in" id="create_project" role="dialog">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">


                    <div class="modal-body">
                        <!-- form start -->
                        <h5 v-show="!editMode" class="modal-title">Add New</h5>
                        <h5 v-show="editMode" class="modal-title">Update Projects's Information</h5>
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
                                <select name="type" v-model="form.country_id" id="type" class="form-control"
                                        :class="{ 'is-invalid': form.errors.has('country_id') }">
                                    <option value="">Select Country</option>
                                    <option v-for="country in countries" :value="country.id">{{country.country_name}}
                                    </option>

                                </select>
                                <has-error :form="form" field="country_id"></has-error>
                            </div>

                            <div class="form-group">
                                <input v-model="form.implementing_office" type="text" name="implementing_office"
                                       placeholder="Implemeting Office"
                                       class="form-control"
                                       :class="{ 'is-invalid': form.errors.has('implementing_office') }">
                                <has-error :form="form" field="implementing_office"></has-error>
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
                                <input v-model="form.amount" type="text" name="amount"
                                       placeholder="Amount"
                                       class="form-control" :class="{ 'is-invalid': form.errors.has('amount') }">
                                <has-error :form="form" field="amount"></has-error>
                            </div>

                            <div class="form-group">

                                <div class="row">
                                    <label class="col-3" for="status_id">Status</label>
                                    <select name="status_id" v-model="form.readiness_id"
                                            id="status_id"
                                            class="form-control  col-7"
                                            :class="{ 'is-invalid': form.errors.has('status_id') }">

                                        <option value="">Select Status</option>
                                        <option v-for="state in status" :value="state.id">{{state.status_name}}</option>
                                    </select>
                                    <has-error :form="form" field="status_id"></has-error>
                                </div>
                            </div>
                            <div class="form-group">

                                <div class="row">
                                    <label class="col-3" for="readiness_id">Readiness Type</label>
                                    <select name="readiness_id" v-model="form.readiness_id"
                                            id="readiness_id"
                                            class="form-control  col-7"
                                            :class="{ 'is-invalid': form.errors.has('readiness_or_nap') }">

                                        <option value="">Select Readiness Type</option>
                                        <option v-for="ready_type in readiness_types" :value="ready_type.id">{{ready_type.readiness_type_name}}</option>
                                    </select>
                                    <has-error :form="form" field="readiness_id"></has-error>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <label class="col-3" for="readiness_or_nap">Readiness Or NAP</label>

                                    <select name="readiness_or_nap" v-model="form.readiness_or_nap" id="readiness_or_nap"
                                            class="form-control col-7"
                                            :class="{ 'is-invalid': form.errors.has('readiness_or_nap') }">

                                        <option value="">Select Readiness or NAP</option>
                                        <option value="1">Readiness</option>
                                        <option value="2">NAP</option>
                                    </select>
                                    <has-error :form="form" field="readiness_or_nap"></has-error>
                                </div>
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
                status: {},
                readiness_types: {},
                countries: {},
                form: new Form({
                    id: '',
                    project_ref: '',
                    project_title: '',
                    implementing_office: '',
                    date_of_gcf: '',
                    start_date: '',
                    country_id: '',
                    duration: '',
                    amount: '',
                    end_date: '',
                    disbursement_id: '',
                    readiness_id: '',
                    readiness_or_nap: '',
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
                            'Project Updated successfully',
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
                                    'The Project has been deleted.',
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
                            title: 'Project Created successfully'
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
            },load_status() {
                axios.get('api/status').then(({data}) => (this.status = data.data));
            },
            load_countries() {
                axios.get('api/country').then(({data}) => (this.countries = data.data));
            }, load_readiness_type() {
                axios.get('api/readiness_type').then(({data}) => (this.readiness_types = data.data));
            }
            ,
            open_my_modal() {
                this.editMode = false;
                this.form.reset();
                $("#create_project").modal('show');
            }, edit_my_modal(project) {
                this.editMode = true;
                this.form.reset();
                $("#create_project").modal('show');
                this.form.fill(project)
            }
        },
        mounted() {
            console.log('Component mounted.')
        }
        ,
        created() {
            this.load_readiness_type();
            this.load_status();
            this.load_projects();
            this.load_countries();
            Fire.$on("ProjectCreated", () => this.load_projects());
            Fire.$on("ProjectDeleted", () => this.load_projects());
            Fire.$on("ProjectUpdated", () => this.load_projects());
            // setInterval(() => this.load_projects(), 10000);
        }
    }
</script>
