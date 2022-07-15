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
                                        <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                            data-bs-target="#formModal" @click="editClient(client)">Edit</button>
                                        <button type="button" class="btn btn-danger"
                                            @click="deleteClient(client.id)">Delete</button>
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

        <modal-form-component @new-client-created-event="addNewClient" @client-updated-event="updateClient"
            :client="clientSelected"></modal-form-component>

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
            clientSelected: null,
        }
    },
    mounted() {
        this.loadList();
    },
    methods: {
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
        editClient(client) {
            this.clientSelected = client;
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
        },
        addNewClient(client) {
            this.clients.push(client);
        },
        updateClient(client) {
            const index = this.clients.findIndex(c => c.id == client.id);
            this.$set(this.clients, index, client);
        }
    },
    mixins: [getToken]
}
</script>
