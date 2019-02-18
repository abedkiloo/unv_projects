<template>
    <div class="container">
        <div class="row">
            <div class="col-sm-12 mt-2">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Country</h3>

                        <div class="card-tools">
                            <button class="btn btn-success"
                                    @click="open_my_modal">
                                <!--data-toggle="modal" data-target="#create_country">-->
                                Add Country <i
                                class="fa fa-user-plus fa-fw"></i></button>
                        </div>
                    </div>
                    <!-- /.box-header -->
                    <div class="card-body table-responsive no-padding">
                        <table class="table table-hover">
                            <tbody>
                            <tr>
                                <th>ID</th>
                                <th>Country Name</th>
                            </tr>
                            <tr v-for="country in countries" :key="country.id">

                                <td>{{country.id}}</td>
                                <td>{{country.country_name}}</td>
                                <td>
                                    <button @click="edit_my_modal(country)">
                                        <i class="fa fa-edit blue"></i>
                                    </button>
                                    <button @click="delete_country(country.id)">
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
        <div class="modal fade in" id="create_country" role="dialog">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">


                    <div class="modal-body">
                        <!-- form start -->
                        <h5 v-show="!editMode" class="modal-title">Add New</h5>
                        <h5 v-show="editMode" class="modal-title">Update Country's Information</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form @submit.prevent="editMode ? update_country():create_country()">
                        <div class="modal-body">
                            <div class="form-group">
                                <input v-model="form.country_name" type="text" name="country_name"
                                       placeholder="Country Name (Ethiopia)"
                                       class="form-control" :class="{ 'is-invalid': form.errors.has('country_name') }">
                                <has-error :form="form" field="country_name"></has-error>
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
                countries: {},
                form: new Form({
                    id: '',
                    country_name: '',
                })
            }
        },
        methods: {
            update_country() {
                this.$Progress.start();

                this.form.put('api/country/' + this.form.id)
                    .then(() => {
                        Fire.$emit('CountryUpdated')
                        $('#create_country').modal('hide');
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
            delete_country(id) {
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

                        this.form.delete('api/country' + id)
                            .then(() => {

                                swal.fire(
                                    'Deleted!',
                                    'The Phase has been deleted.',
                                    'success'
                                )
                                Fire.$emit("CountryDeleted");
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
            create_country() {

                this.$Progress.start();

                this.form.post('api/country')
                    .then(() => {
                        Fire.$emit("CountryCreated")

                        $('#create_country').modal('hide');

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
            load_countries() {
                axios.get('api/country').then(({data}) => (this.countries = data.data));
            }
            ,
            open_my_modal() {
                this.editMode = false;
                this.form.reset();
                $("#create_country").modal('show');
            }, edit_my_modal(user) {
                this.editMode = true;
                console.log(user)
                this.form.reset();
                $("#create_country").modal('show');
                this.form.fill(user)
            }
        },
        mounted() {
            console.log('Component mounted.')
        }
        ,
        created() {
            this.load_countries();
            Fire.$on("CountryCreated", () => this.load_countries());
            Fire.$on("CountryDeleted", () => this.load_countries());
            Fire.$on("CountryUpdated", () => this.load_countries());
            // setInterval(() => this.load_countries(), 10000);
        }
    }
</script>
