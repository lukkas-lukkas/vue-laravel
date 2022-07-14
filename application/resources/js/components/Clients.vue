<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">

                <!--List-->
                <div class="card mb-3">
                    <div class="card-header">Clients</div>

                    <div class="card-body">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>NAME</th>
                                    <th>#</th>
                                </tr>
                            </thead>

                            <tbody v-if="clients.length > 0 && !loading">
                                <tr v-for="client in clients">
                                    <td>{{ client.id }}</td>
                                    <td>{{ client.name }}</td>
                                    <td>
                                        <button type="button" class="btn btn-primary" @click="editClient(client.id)">Edit</button>
                                        <button type="button" class="btn btn-danger" @click="deleteClient(client.id)">Delete</button>
                                    </td>
                                </tr>
                            </tbody>

                            <tbody v-if="!loading && clients.length == 0">
                                <tr>
                                    <td colspan="2">
                                        Anyone client here
                                    </td>
                                </tr>
                            </tbody>

                            <tbody v-if="loading">
                                <tr>
                                    <td class="placeholder-glow">
                                        <span class="placeholder col-3"></span>
                                    </td>
                                    <td class="placeholder-glow">
                                        <span class="placeholder col-3"></span>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <div class="card-footer text-end">
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                            data-bs-target="#formModal">Create</button>
                    </div>
                </div>
                <!--List-->

            </div>
        </div>

        <!--Modal-->
        <div class="modal fade" id="formModal" tabindex="-1" aria-labelledby="formModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="formModalLabel">Create client</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="nameToCreate" class="form-label">Name</label>
                            <input type="text" class="form-control" id="nameToCreate" v-model="nameToCreate" placeholder="Client name">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button id="btnCloseModal" type="button" class="btn btn-secondary" data-bs-dismiss="modal" @click="clearModal">Close</button>
                        <button type="button" class="btn btn-primary" @click="createClient">Save</button>
                    </div>
                </div>
            </div>
        </div>
        <!--Modal-->
    </div>
</template>

<script>
import { URL_BASE } from '../constants';
import { getToken } from '../mixins';

export default {
    data() {
        return {
            clients: [],
            loading: true,
            nameToCreate: '',
        }
    },
    mounted() {
        this.loadList();
    },
    methods: {
        clearModal() {
            this.nameToCreate = '';
        },
        createClient() {
            if (this.nameToCreate.length == 0) {
                alert('Name is required');
                this.closeModal();
                return;
            }

            const formData = new FormData();
            formData.append('name', this.nameToCreate);

            const token = this.getToken();

            const url = `${URL_BASE}/api/client`;
            const config = {
                method: 'post',
                body: formData,
                headers: new Headers({
                    Authorization: `Bearer ${token}`
                })
            };

            fetch(url, config)
                .then(response => response.json())
                .then(client => {
                    this.clients.push(client);
                    this.closeModal();
                    alert('Create client success');

                })
                .catch(error => alert('Create error'));
        },
        closeModal() {
            btnCloseModal.click();
        },
        deleteClient(id) {
            const token = this.getToken();

            const url = `${URL_BASE}/api/client/${id}`;
            const config = {
                method: 'delete',
                headers: new Headers({
                    Authorization: `Bearer ${token}`
                })
            };

            fetch(url, config)
                .then(response => {
                    this.clients = this.clients.filter(client => client.id != id);
                    alert('Delete client success');

                })
                .catch(error => alert('Create error'));
        },
        editClient(id) {
            this.loading = true;
            const name = prompt('New client name:');

            const token = this.getToken();
            const url = `${URL_BASE}/api/client/${id}`;
            const config = {
                method: 'put',
                body: JSON.stringify({name}),
                headers: new Headers({
                    'Authorization': `Bearer ${token}`,
                    'Content-Type': 'application/json'
                })
            };

            fetch(url, config)
                .then(response => {
                    this.loadList();
                    alert('Client update success');                    
                })
                .catch(error => alert('Error api'))
                .finally(() => {
                    this.loading = false;
                })

            
        },
        loadList() {
            const token = this.getToken();
            const url = `${URL_BASE}/api/client`;
            const config = {
                method: 'get',
                headers: new Headers({
                    'Authorization': `Bearer ${token}`
                })
            };
            fetch(url, config)
                .then(response => response.json())
                .then(data => {
                    this.clients = data;
                    this.loading = false;
                })
                .catch(error => alert('Error api'))
        }
    },
    mixins: [getToken]
}
</script>
