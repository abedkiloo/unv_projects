<template>
    <div class="container">
        <div class="row">
            <div class="col-sm-12 mt-2">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Users Table</h3>

                        <div class="card-tools">
                            <button class="btn btn-success"
                                data-toggle="modal" data-target="#create_user">
                                <!--@click="open_modal">-->

                                Add User <i
                                class="fa fa-user-plus fa-fw"></i></button>
                        </div>
                    </div>
                    <!-- /.box-header -->
                    <div class="card-body table-responsive no-padding">
                        <table class="table table-hover">
                            <tbody>
                            <tr>
                                <th>ID</th>
                                <th>User</th>
                                <th>Email</th>
                                <th>Type</th>
                                <th>Registered At</th>
                                <th>Modify</th>
                            </tr>
                            <tr v-for="user in users" :key="user.id">
                                <td>{{user.id}}</td>
                                <td>{{user.name}}</td>
                                <td>{{user.email}}</td>
                                <td>{{user.type | custom_user_type}}</td>
                                <td>{{user.created_at | custom_date}}</td>
                                <td>
                                    <button>
                                        <i class="fa fa-edit blue"></i>
                                    </button>
                                    <button>
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
        <div class="modal fade in" id="create_user" role="dialog">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Add New User</h4>

                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span></button>
                    </div>
                    <form class="form form-inline" @submit.prevent="create_user">

                        <div class="modal-body">
                            <div class="card card-info">
                                <!-- form start -->
                                <div class="card-body">
                                    <div class="form-group">
                                        <label for="names" class="col-sm-2 control-label">Name</label>

                                        <div class="col-sm-10">
                                            <input type="text" class="form-control"
                                                   id="names"
                                                   name="names"
                                                   v-model="form.names"
                                                   placeholder="Names"
                                                   :class="{'is-invalid': form.errors.has('names')}">
                                            <has-error :form="form" field="names"></has-error>

                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="user_email" class="col-sm-2 control-label">Email</label>

                                        <div class="col-sm-10">
                                            <input type="email" class="form-control"
                                                   id="user_email"
                                                   name="user_email"
                                                   v-model="form.user_email"
                                                   placeholder="Email"
                                                   :class="{'is-invalid': form.errors.has('user_email')}">
                                            <has-error :form="form" field="user_email"></has-error>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="type" class="col-sm-2 control-label">Type</label>

                                        <div class="col-sm-10">
                                            <select class="form-control"
                                                    :class="{'is-invalid': form.errors.has('type')}"
                                                    id="type"
                                                    name="type"
                                                    v-model="form.type">
                                                <option value="">--Select User --</option>
                                                <option value="1">Admin</option>
                                                <option value="2">Author</option>
                                                <option value="3">Standard User</option>
                                            </select>
                                            <has-error :form="form" field="type"></has-error>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="bio" class="col-sm-2 control-label">Bio</label>

                                        <div class="col-sm-10">
                                            <textarea class="form-control"
                                                      id="bio"
                                                      name="bio"
                                                      v-model="form.bio"
                                                      :class="{'is-invalid': form.errors.has('user_password')}">
                                            </textarea>
                                            <has-error :form="form" field="bio"></has-error>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="user_password" class="col-sm-2 control-label">Password</label>

                                        <div class="col-sm-10">
                                            <input type="password" class="form-control"
                                                   id="user_password"
                                                   name="user_password"
                                                   v-model="form.user_password"
                                                   placeholder="Password"
                                                   :class="{'is-invalid': form.errors.has('user_password')}">
                                            <has-error :form="form" field="user_password"></has-error>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger pull-left" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Create</button>
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
                users: {},
                form: new Form({
                    names: '',
                    type: '',
                    user_email: '',
                    user_password: '',
                    bio: '',
                })
            }
        },
        methods: {
            create_user() {

                this.$Progress.start()

                this.form.post('api/user')

                toast.fire({
                    type: 'success',
                    title: 'User Created successfully'
                })
                this.$Progress.finish()

            }, load_users() {
                axios.get('api/user').then(({data}) => (this.users = data.data));
            },
            open_modal() {

            }
        },
        mounted() {
            console.log('Component mounted.')
        }, created() {
            this.load_users();
        }
    }
</script>
