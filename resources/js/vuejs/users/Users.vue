<template>
    <div>
        <div class="max-w-7xl mx-auto px-5 md:px-8">
            <button @click="handleIsOpenAddModal('add', true)" class="flex flex-row items-center py-3 px-5 text-white bg-red-500 mb-5 rounded-md">
                <p>Add Users</p>
                <ion-icon class="ml-3 text-2xl" name="add-outline"></ion-icon>
            </button>
            <div class="flex flex-col justify-end items-end">
                <div class="w-full">
                    <div class="relative flex flex-wrap justify-end items-end bg-white p-5">
                        <div class="flex flex-row w-60 items-center">
                            <input
                                type="search"
                                class="relative m-0 block w-60 flex-auto rounded border-0 border-b-2 border-b-solid border-b-gray-300 bg-transparent bg-clip-padding px-3 py-[0.25rem] text-base font-normal leading-[1.6] text-neutral-700 outline-none transition duration-200 ease-in-out focus:z-[3] focus:outline-none"
                                placeholder="Search"
                                aria-label="Search"
                                aria-describedby="button-addon2"
                                v-model="search"
                                @keypress="fetchData(parseInt(pagination.current), parseInt(pagination.pageSize), search)"
                            />
                            <span
                                class="input-group-text flex items-center whitespace-nowrap rounded px-3 py-1.5 text-center text-base font-normal text-gray-400"
                                id="basic-addon2">
                                <svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    viewBox="0 0 20 20"
                                    fill="currentColor"
                                    class="h-5 w-5">
                                    <path
                                        fill-rule="evenodd"
                                        d="M9 3.5a5.5 5.5 0 100 11 5.5 5.5 0 000-11zM2 9a7 7 0 1112.452 4.391l3.328 3.329a.75.75 0 11-1.06 1.06l-3.329-3.328A7 7 0 012 9z"
                                        clip-rule="evenodd"
                                    />
                                </svg>
                            </span>
                        </div>
                    </div>
                </div>
                <div class="overflow-hidden w-full">
                    <div class="flex flex-col justify-center px-5 py-4" :class="alert.status === 'success' ? 'bg-green-500 text-white' : 'bg-red-500 text-white'" v-if="alert.status">
                        <p>{{ alert.message }}</p>
                    </div>
                    <div class="overflow-auto bg-white rounded-md p-5">
                        <Table
                            :columns="columns"
                            :dataSource="items"
                            :pagination="{ pageSize: 5, current: pagination.current, total: pagination.total }"
                            @change="handleChangeTable"
                        >
                            <template #name="record">
                                <div class="flex flex-row items-center w-[250px]">
                                    <p>{{ record.record.name }}</p>
                                </div>
                            </template>
                            <template #action="record">
                                <button class="px-4 py-3 m-1 bg-slate-700 rounded-md text-white" type="primary" @click="handleIsOpenAddModal('edit', true), editRecord(record)"><ion-icon name="create-outline"></ion-icon></button>
                                <button class="px-4 py-3 m-1 bg-red-500 rounded-md text-white" type="danger" @click="handleAlertDelete(record)"><ion-icon name="trash-outline"></ion-icon></button>
                            </template>
                        </Table>
                    </div>
                </div>
            </div>
            <div class="bg-[#0006] w-screen h-screen fixed z-20 top-0 left-0 flex items-center" v-if="isOpenAddModal.status">
                <div class="bg-white w-9/12 h-[90%] md:h-auto overflow-y-auto m-auto p-7 rounded-md">
                    <ion-icon @click="handleIsOpenAddModal({ type: false, status: false })" class="cursor-pointer text-2xl mb-4" name="close-outline"></ion-icon>
                    <form @submit.prevent="handleSubmit">
                        <div class="grid grid-cols-1">
                            <div class="flex flex-wrap items-center w-full mb-5">
                                <label class="mr-3 w-28">Nama :</label>
                                <input class="w-full mt-2 rounded-md" type="text" placeholder="Nama..." name="name" v-model="formData.name" required />
                            </div>
                            <div class="flex flex-wrap items-center w-full mb-5">
                                <label class="mr-3 w-28">Email :</label>
                                <input class="w-full mt-2 rounded-md" type="text" placeholder="Email..." name="email" v-model="formData.email" required />
                            </div>
                            <div class="flex flex-wrap items-center w-full mb-5">
                                <label class="mr-3 w-28">Password :</label>
                                <input class="w-full mt-2 rounded-md" type="password" placeholder="Password..." name="password" v-model="formData.password" />
                            </div>
                            <div class="flex flex-wrap items-center w-full mb-5">
                                <label class="mr-3 w-28">Roles :</label>
                                <Select
                                    class="w-full mt-2"
                                    showSearch
                                    placeholder="Search to Select"
                                    :options="options"
                                    @change="handleSelectChange"
                                    :value="formData.isAdmin"
                                />
                            </div>
                            <button type="submit" class="mt-5 rounded-md px-3 py-3 bg-red-500 text-white font-bold">
                                Submit
                            </button>
                        </div>
                    </form>
                </div>
            </div>
            <AlertConfirm
                v-if="isAlertDelete"
                text="Apa Anda Yakin ingin menghapus?"
                @confirmed="deleteItem"
                @canceled="isAlertDelete = false"
            />
        </div>
        <div class="overflow-hidden w-full bg-white mt-10 px-5 md:px-10">
            <h2 class="font-bold text-2xl p-5">History & Note</h2>
            <div class="overflow-auto bg-white rounded-md p-5">
                <Table
                    :columns="column_audits"
                    :dataSource="item_audits"
                    :pagination="{ pageSize: 5, current: pagination.current, total: pagination.total_pages }"
                    @change="handleChangeTableAudits"
                />
            </div>
        </div>
    </div>
</template>

<script>
import { Table, Select } from 'ant-design-vue';
import axios from 'axios';
import AlertConfirm from '../components/AlertConfirm.vue';
import { formatDateYMD } from '../../helpers/function'
export default {
    components : {
        Table,
        Select,
        AlertConfirm
    },
    data() {
        return {
            columns : [
                {
                    title: 'Name',
                    dataIndex: 'name',
                    slots: { customRender: 'name' },
                },
                {
                    title: 'Email',
                    dataIndex: 'email',
                },
                {
                    title: 'Roles',
                    dataIndex: 'isAdmin',
                },
                {
                    title: 'Tanggal Buat',
                    dataIndex: 'created_at',
                },
                {
                    title: 'Tanggal Verifikasi',
                    dataIndex: 'verified_at',
                },
                {
                    title: 'Action',
                    dataIndex: 'action',
                    slots: { customRender: 'action' },
                },
            ],
            items : [],
            pagination: {
                current: 1,
                pageSize: 5,
                total: 0,
            },
            editValue: false,
            newItemName: '',
            isOpenAddModal : {
                type: false,
                status: false
            },
            column_audits : [
                {
                    title: 'Tanggal',
                    dataIndex: 'date',
                },
                {
                    title: 'Action',
                    dataIndex: 'action',
                },
                {
                    title: 'User',
                    dataIndex: 'user',
                },
                {
                    title: 'IP Address',
                    dataIndex: 'note',
                },
            ],
            item_audits : [],
            pagination_audits: {
                current: 1,
                pageSize: 5,
                total: 0,
            },
            isAlertDelete: false,
            isConfirmDelete: false,
            formData: {
                id: '',
                name: '',
                email: '',
                password: '',
                isAdmin: '',
                created_at: '',
                verified_at: '',
            },
            alert: {
                status: false,
                message: false
            },
            options: [
                {
                    label: 'Admin',
                    value: 1,
                },
                {
                    label: 'User',
                    value: '',
                }
            ],
            search: ''
        };
    },
    mounted() {
        this.fetchData(parseInt(this.pagination.current), parseInt(this.pagination.pageSize), this.search);
        this.fetchDataHistory(parseInt(this.pagination.current), parseInt(this.pagination.pageSize), this.search);
    },
    computed: {
        rowSelection() {
            return {
                selectedRowKeys: this.selectedRowKeys,
                onChange: this.onRowSelectionChange,
            };
        },
    },
    methods: {
        formatDateYMD,
        handleSubmit() {
            if(this.isOpenAddModal.type === 'edit') {
                this.editItem()
            } else {
                this.addItem()
            }
        },
        handleSelectChange(value) {
            this.formData.isAdmin = value
        },
        handleIsOpenAddModal(type, value) {
            if(type === 'add') {
                this.formData = {
                    id: '',
                    name: '',
                    email: '',
                    password: '',
                    isAdmin: '',
                    created_at: '',
                    verified_at: ''
                }
            }
            this.isOpenAddModal.status = value;
            this.isOpenAddModal.type = type;
        },
        onDropzoneSuccess(file, response) {
            console.log('File uploaded successfully!', file, response);
        },
        onDropzoneError(file, error) {
            console.error('Error uploading file!', file, error);
        },
        handleChangeTable(pagination) {
            this.pagination = pagination;
            this.fetchData(parseInt(this.pagination.current), parseInt(this.pagination.pageSize), this.search);
        },
        fetchData(current, pageSize, search) {
            axios.get(`/api/users?perPage=${pageSize}&page=${current}&type=search&name=${search}`, {
                headers: {
                    'Content-Type': 'application/json',
                    Authorization: 'Bearer' + $.cookie('jwtToken')
                }
            })
            .then(response => {
                const item = [];
                this.pagination.total = parseInt(response.data.pagination.total);
                this.pagination.current = parseInt(response.data.pagination.page);
                this.pagination.pageSize = parseInt(response.data.pagination.per_page);
                response?.data?.data?.map((v, i) => {
                    item.push({
                        key: i,
                        id: v.id,
                        name: v.name,
                        email: v.email,
                        isAdmin: v.isAdmin == '1' ? 'Admin' : 'User',
                        verified_at: v.verified_at,
                        created_at: this.formatDateYMD(new Date(v.created_at)),
                    })
                });
                this.items = item;
            })
            .catch(error => {
                console.error('Error fetching items:', error);
            });
        },
        fetchDataHistory(current, pageSize, search) {
            axios.get(`/api/users?perPage=${pageSize}&page=${current}&type=audits&name=${search}`, {
            headers: {
                'Content-Type': 'application/json',
                Authorization: 'Bearer' + $.cookie('jwtToken')
            }})
            .then(response => {
                const item = [];
                this.pagination_audits.total = parseInt(response.data.pagination.total);
                this.pagination_audits.current = parseInt(response.data.pagination.page);
                this.pagination_audits.pageSize = parseInt(response.data.pagination.per_page);
                response?.data?.data?.map((v, i) => {
                    item.push({
                        key: i,
                        id: v.id,
                        date: this.formatDateYMD(new Date(v.created_at)),
                        action: v.event,
                        user: v.user.name,
                        note: v.ip_address
                    })
                });
                this.item_audits = item;
            })
            .catch(error => {
                console.error('Error fetching items:', error);
            });
        },
        handleChangeTableAudits(pagination) {
            this.pagination_audits = pagination;
            this.fetchData(parseInt(this.pagination_audits.current), parseInt(this.pagination_audits.pageSize), this.search);
        },
        editRecord(record) {
            axios.get(`/api/users/${record.record.id}`, {
                headers: {
                    'Content-Type': 'application/json',
                    Authorization: 'Bearer' + $.cookie('jwtToken')
                }
            })
            .then(response => {
                response?.data?.data?.map((v, i) => {
                    this.formData = {
                        key: i,
                        id: v.id,
                        name: v.name,
                        email: v.email,
                        isAdmin: {
                            label: v.isAdmin ? 'Admin' : 'User',
                            value: v.isAdmin,
                        },
                        verified_at: v.verified_at,
                        created_at: v.created_at,
                    }
                });
            })
            .catch(error => {
                console.error('Error fetching items:', error);
            });
        },
        editItem() {
            this.formData.isAdmin = this.formData.isAdmin.value;
            axios.put(`/api/users`, JSON.stringify(this.formData), {
                headers: {
                    'Content-Type': 'application/json',
                    Authorization: 'Bearer' + $.cookie('jwtToken')
                }
            })
            .then(response => {
                this.alert.status = response.data.meta.status;
                this.alert.message = response.data.meta.message;
                setTimeout(() => {
                    this.alert.status = false;
                    this.alert.message = false;
                }, 2000);
                this.isOpenAddModal.status = false;
                this.fetchData(parseInt(this.pagination.current), parseInt(this.pagination.pageSize), this.search);
                this.fetchDataHistory(parseInt(this.pagination.current), parseInt(this.pagination.pageSize), this.search);

            })
            .catch(error => {
                console.error('Error updating item:', error);
            });
        },
        addItem() {
            axios.post('/api/users', this.formData, {
                headers: {
                    'Content-Type': 'multipart/form-data',
                    Authorization: 'Bearer' + $.cookie('jwtToken')
                },
            })
            .then(response => {
                this.alert.status = response.data.meta.status;
                this.alert.message = response.data.meta.message;
                setTimeout(() => {
                    this.alert.status = false;
                    this.alert.message = false;
                }, 2000);
                this.isOpenAddModal.status = false;
                this.fetchData(parseInt(this.pagination.current), parseInt(this.pagination.pageSize), this.search);
                this.fetchDataHistory(parseInt(this.pagination.current), parseInt(this.pagination.pageSize), this.search);
            })
            .catch(error => {
                console.error('Error adding item:', error);
            });
        },
        handleAlertDelete(record) {
            this.formData.id = record.record.id;
            this.isAlertDelete = true;
        },
        deleteItem() {
            axios.delete('/api/users/' + this.formData.id, {
                headers: {
                    'Content-Type': 'multipart/form-data',
                    Authorization: 'Bearer' + $.cookie('jwtToken')
                },
            })
            .then(response => {
                this.isOpenAddModal.status = false;
                this.formData.id = false;
                this.isAlertDelete = false;
                this.alert.status = response.data.meta.status;
                this.alert.message = response.data.meta.message;
                this.fetchData(parseInt(this.pagination.current), parseInt(this.pagination.pageSize), this.search);
                this.fetchDataHistory(parseInt(this.pagination.current), parseInt(this.pagination.pageSize), this.search);
            })
            .catch(error => {
                console.error('Error adding item:', error);
            });
        },
    }
}
</script>
