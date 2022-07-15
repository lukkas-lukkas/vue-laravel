<template>
    <div class="modal fade" id="formModal" tabindex="-1" aria-labelledby="formModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="formModalLabel">{{ modalTitle }} client</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                        @click="clearModal"></button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="nameToCreate" class="form-label">Name</label>
                        <input type="text" class="form-control" id="nameToCreate" v-model="name"
                            placeholder="Client name">
                    </div>
                </div>
                <div class="modal-footer">
                    <button id="btnCloseModal" type="button" class="btn btn-secondary" data-bs-dismiss="modal"
                        @click="clearModal">Close</button>
                    <button type="button" class="btn btn-primary" @click="save">Save</button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import clientHttp from '../clientHttp';
import { getToken } from '../mixins';

export default {
    data() {
        return {
            name: '',
            clientData: null,
        }
    },
    props: ['client'],
    watch: {
        client() {
            if (this.client) {
                this.name = this.client.name;
            }

            this.clientData = this.client;
        }
    },
    computed: {
        modalTitle() {
            return this.clientData ? 'Edit' : 'Create';
        }
    },
    methods: {
        clearModal() {
            this.clientData = null;
            this.name = '';
            this.$emit('modal-closed-event');
        },
        closeModal() {
            btnCloseModal.click();
        },
        save() {
            if (this.name.length == 0) {
                alert('Name is required');
                this.closeModal();
                return;
            }

            const config = {
                headers: {
                    Authorization: `Bearer ${this.getToken()}`,
                }
            };

            const params = {
                name: this.name,
            };

            if (this.clientData) {
                // EDIT
                if (this.name == this.clientData.name) {
                    this.closeModal();
                    return;
                }

                clientHttp.put(`/api/client/${this.clientData.id}`, params, config).then(response => {
                    const client = response.data;
                    this.$emit('client-updated-event', client);
                    alert('Client update success');
                }).catch(() => {
                    alert('Sorry, we have some problem ...');
                });

                this.closeModal();
                return;
            }

            // CREATE
            clientHttp.post(`/api/client`, params, config).then(response => {
                const client = response.data;
                this.$emit('new-client-created-event', client);
                this.closeModal();
                alert('Create client success');
            }).catch(() => {
                alert('Sorry, we have some problem ...');
            });
        }
    },
    mixins: [getToken]
}
</script>