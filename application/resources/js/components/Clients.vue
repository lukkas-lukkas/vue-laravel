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
                                </tr>
                            </thead>

                            <tbody v-if="clients.length > 0">
                                <tr v-for="client in clients">
                                    <td>{{ client.id }}</td>
                                    <td>{{ client.name }}</td>
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
                </div>
                <!--List-->

            </div>
        </div>
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
        }
    },
    mounted() {
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
    mixins: [getToken]
}
</script>
