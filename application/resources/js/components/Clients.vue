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

        <modal-form-component @new-client-created-event="addNewClient" @client-updated-event="updateClient" @modal-closed-event="resetModal"
            :client="clientSelected"></modal-form-component>

    </div>
</template>

<script>
import clientHttp from '../clientHttp';
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
            clientHttp.delete(`/api/client/${id}`, {
                headers: {
                    Authorization: `Bearer ${this.getToken()}`
                }
            }).then(() => {
                this.clients = this.clients.filter(client => client.id != id);
                alert('Delete client success');
            }).catch(() => {
                alert('Sorry, we have some problem ...')
            });
        },
        editClient(client) {
            this.clientSelected = client;
        },
        loadList() {
            clientHttp.get('/api/client', {
                headers: {
                    Authorization: `Bearer ${this.getToken()}`
                }
            }).then(response => {
                this.clients = response.data;
                this.loading = false;
            }).catch(error => {
                alert('Sorry, we have some problem ...');
            })
        },
        addNewClient(client) {
            this.clients.push(client);
        },
        updateClient(client) {
            const index = this.clients.findIndex(c => c.id == client.id);
            this.$set(this.clients, index, client);
        },
        resetModal() {
            this.clientSelected = null;
        }
    },
    mixins: [getToken]
}
</script>
