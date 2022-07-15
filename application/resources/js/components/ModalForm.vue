<template>
    <div class="modal fade" id="formModal" tabindex="-1" aria-labelledby="formModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="formModalLabel">Create client</h5>
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
import { URL_BASE } from '../constants';
import { getToken } from '../mixins';

export default {
    data() {
        return {
            name: ''
        }
    },
    methods: {
        clearModal() {
            this.name = '';
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

            const formData = new FormData();
            formData.append('name', this.name);

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
                    this.$emit('new-client-created-event', client);
                    this.closeModal();
                    alert('Create client success');

                })
                .catch(error => alert('Create error'));
        }
    },
    mixins: [getToken]
}
</script>