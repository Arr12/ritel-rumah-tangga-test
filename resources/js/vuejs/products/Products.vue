<template>
    <div>
        <div class="max-w-7xl mx-auto px-5 md:px-8">
            <div class="flex flex-row items-center">
                <button @click="handleIsOpenAddModal('add', true)" class="flex flex-row items-center py-3 px-5 text-white bg-red-500 mb-5 rounded-md">
                    <ion-icon class="text-xl mr-2" name="add-outline"></ion-icon>
                    <p>Add Product</p>
                </button>
                <TableExportButton
                    :dataExport="items_export"
                    :fileName="`product_list_${formatDateYMD(new Date())}`"
                    :docTitle="`Data Produk`"
                    :isHideExportFunction="false"
                >
                    <template #content>
                        <div class="flex flex-wrap items-center w-full mb-5">
                            <label class="mr-3 w-28">Kategori :</label>
                            <Select
                                class="w-full mt-2"
                                showSearch
                                placeholder="Search to Select"
                                :options="options"
                                @search="handleSearchCategories"
                                @change="handleExportCategories"
                            />
                        </div>
                    </template>
                </TableExportButton>
            </div>
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
                                <div class="flex flex-row items-center w-[250px] cursor-pointer" @click="handleOpenImageDetail(record)">
                                    <img class="object-cover rounded-full w-24 h-24 mr-3" :src="record.record.thumbnail ? JSON.parse(record.record.thumbnail)[0] : ''" :alt="record.record.name" :srcSet="record.record.thumbnail ? JSON.parse(record.record.thumbnail)[0] : ''" width="auto" height="auto" onerror="this.src='/images/no-image.png'" />
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
            <div class="bg-[#0006] w-screen h-screen fixed z-20 top-0 left-0 flex items-center" v-if="isOpenImagesDetail">
                <div class="bg-white w-9/12 h-[90%] md:h-auto overflow-y-auto m-auto p-7 rounded-md">
                    <ion-icon @click="isOpenImagesDetail = false" class="cursor-pointer text-2xl mb-4" name="close-outline"></ion-icon>
                    <div class="flex flex-col md:flex-row flex-wrap items-center w-full">
                        <template v-for="(item, index) in formData.thumbnail">
                            <template v-if="index === 0">
                                <div class="w-full md:w-1/4 bg-orange-400 mb-3 py-3 rounded-md">
                                    <img class="h-64 mb-2 object-contain w-full px-3" :src="item" :srcset="item" width="auto" height="auto" />
                                    <p class="font-bold text-center text-white">Profil</p>
                                </div>
                                </template>
                                <template v-if="index > 0">
                                <div class="w-full md:w-1/4 mb-3">
                                    <img class="h-36 object-contain w-full" :src="item" :srcset="item" width="auto" height="auto" />
                                    <p class="font-bold text-center">Galeri</p>
                                </div>
                                </template>
                        </template>
                    </div>
                </div>
            </div>
            <div class="bg-[#0006] w-screen h-screen fixed z-20 top-0 left-0 flex items-center" v-if="isOpenAddModal.status">
                <div class="bg-white w-9/12 h-[90%] md:h-auto overflow-y-auto m-auto p-7 rounded-md">
                    <ion-icon @click="handleIsOpenAddModal({ type: false, status: false })" class="cursor-pointer text-2xl mb-4" name="close-outline"></ion-icon>
                    <form @submit.prevent="handleSubmit">
                        <div class="grid grid-cols-1 md:grid-cols-2">
                            <div class="p-5 lg:px-10">
                                <label className="mb-5 flex flex-col items-center py-28 md:py-32 justify-center h-32 lg:h-full px-4 transition bg-white border-2 border-gray-300 border-dashed rounded-md appearance-none cursor-pointer hover:border-gray-400 focus:outline-none">
                                    <span className="flex items-center space-x-2">
                                        <img
                                            :src="formData?.thumbnail[0] ? formData?.thumbnail[0] : '/images/blank-pp.png'"
                                            :srcSet="formData?.thumbnail[0] ? formData?.thumbnail[0] : '/images/blank-pp.png'"
                                            class="w-48 p-5 bg-[#F6F6F6]"
                                            width="auto"
                                            height="auto"
                                            onError="/images/no-image.png"
                                        />
                                    </span>
                                    <input
                                        type="file"
                                        ref="fileInput"
                                        @change="handleFileChange"
                                        name="file_upload"
                                        class="hidden"
                                        multiple
                                    />
                                </label>
                            </div>
                            <div class="grid grid-cols-1">
                                <div class="flex flex-wrap items-center w-full mb-5">
                                    <label class="mr-3 w-28">Nama Produk :</label>
                                    <input class="w-full mt-2 rounded-md" type="text" placeholder="Nama Produk..." name="produk" v-model="formData.name" required />
                                </div>
                                <div class="flex flex-wrap items-center w-full mb-5">
                                    <label class="mr-3 w-28">Rating :</label>
                                    <input class="w-full mt-2 rounded-md" type="text" placeholder="Rating..." name="rating" v-model="formData.rating" required />
                                </div>
                                <div class="flex flex-wrap items-center w-full mb-5">
                                    <label class="mr-3 w-28">Harga :</label>
                                    <input class="w-full mt-2 rounded-md" type="text" placeholder="Harga..." name="price" v-model="formData.price" required />
                                </div>
                                <div class="flex flex-wrap items-center w-full mb-5">
                                    <label class="mr-3 w-28">Stok :</label>
                                    <input class="w-full mt-2 rounded-md" type="text" placeholder="Stok..." name="stock" v-model="formData.stock" required />
                                </div>
                                <div class="flex flex-wrap items-center w-full mb-5">
                                    <label class="mr-3 w-28">Kategori :</label>
                                    <Select
                                        class="w-full mt-2"
                                        showSearch
                                        placeholder="Search to Select"
                                        :options="options"
                                        @search="handleSearchCategories"
                                        @change="handleSelectChange"
                                        :value="formData.categories_id"
                                    />
                                </div>
                                <button type="submit" class="mt-5 rounded-md px-3 py-3 bg-red-500 text-white font-bold">
                                    Submit
                                </button>
                            </div>
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
                    :pagination="{ pageSize: 5, current: pagination_audits.current, total: pagination_audits.total_pages }"
                    @change="handleChangeTableAudits"
                />
            </div>
        </div>
    </div>
</template>

<script>
import VueHtml2pdf from 'vue-html2pdf'
import { Table, Select } from 'ant-design-vue';
import axios from 'axios';
import AlertConfirm from '../components/AlertConfirm.vue';
import { formatRupiah, formatDateYMD } from '../../helpers/function'
import TableExportButton from '../components/TableExportButton.vue'

export default {
    components : {
        Table,
        Select,
        AlertConfirm,
        VueHtml2pdf,
        TableExportButton
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
                    title: 'Url Produk',
                    dataIndex: 'slug',
                },
                {
                    title: 'Deskripsi',
                    dataIndex: 'description',
                },
                {
                    title: 'Rating',
                    dataIndex: 'rating',
                },
                {
                    title: 'Harga',
                    dataIndex: 'price',
                },
                {
                    title: 'Stok',
                    dataIndex: 'stock',
                },
                {
                    title: 'Action',
                    dataIndex: 'action',
                    slots: { customRender: 'action' },
                },
            ],
            items : [],
            items_export : {
                isLoaded: false,
                body : [],
                head : []
            },
            pagination: {
                current: 1,
                pageSize: 5,
                total: 0,
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
            editValue: false,
            isOpenImagesDetail: false,
            isOpenPrintModal: false,
            exportCategories: false,
            newItemName: '',
            isOpenAddModal : {
                type: false,
                status: false
            },
            isAlertDelete: false,
            isConfirmDelete: false,
            formData: {
                id: '',
                name: '',
                rating: '',
                price: '',
                stock: '',
                thumbnail: '',
                categories_id: ''
            },
            alert: {
                status: false,
                message: false
            },
            options: [],
            search: ''
        };
    },
    mounted() {
        this.fetchData(parseInt(this.pagination.current), parseInt(this.pagination.pageSize), this.search);
        this.fetchDataHistory(parseInt(this.pagination.current), parseInt(this.pagination.pageSize), this.search);
        this.fetchOptionsCategories();
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
        formatRupiah,
        formatDateYMD,
        handleExportCategories(value) {
            this.exportCategories = value
            this.items_export.head = []
            this.items_export.head.push([
                'Nama',
                'Url Produk',
                'Rating',
                'Harga',
                'Stock'
            ])
            this.fetchDataExport();
        },
        handleOpenImageDetail(record){
            axios.get(`/api/products/${record.record.id}`)
            .then(response => {
                response?.data?.data?.map((v, i) => {
                    this.formData = {
                        id: v.id,
                        name: v.name,
                        rating: v.rating,
                        price: v.price,
                        stock: v.stock,
                        thumbnail: v.thumbnail ? JSON.parse(v.thumbnail) : '',
                        categories_id: {
                            label: v?.categories?.name,
                            value: v?.categories_id
                        }
                    }
                });
            })
            .catch(error => {
                console.error('Error fetching items:', error);
            });
            this.isOpenImagesDetail = true
        },
        handleSubmit() {
            if(this.isOpenAddModal.type === 'edit') {
                this.editItem()
            } else {
                this.addItem()
            }
        },
        handleFileChange() {
            axios.post('/api/products/uploads', {
                files : this.$refs.fileInput.files,
                description: '',
                category: 'products',
            }, {
                headers: {
                    'Content-Type': 'multipart/form-data',
                    Authorization: 'Bearer' + $.cookie('jwtToken')
                },
            })
            .then(response => {
                this.formData.thumbnail = response.data.data
            })
            .catch(error => {
                console.error('Error uploading file:', error);
            });
        },
        handleSelectChange(value) {
            this.formData.categories_id = value
        },
        handleIsOpenAddModal(type, value) {
            if(type === 'add') {
                this.formData = {
                    id: '',
                    name: '',
                    rating: '',
                    price: '',
                    stock: '',
                    thumbnail: '',
                    categories_id: ''
                }
            }
            this.isOpenAddModal.status = value;
            this.isOpenAddModal.type = type;
        },
        handleChangeTable(pagination) {
            this.pagination = pagination;
            this.fetchData(parseInt(this.pagination.current), parseInt(this.pagination.pageSize), this.search);
        },
        handleChangeTableAudits(pagination) {
            this.pagination_audits = pagination;
            this.fetchData(parseInt(this.pagination_audits.current), parseInt(this.pagination_audits.pageSize), this.search);
        },
        fetchData(current, pageSize, search) {
            axios.get(`/api/products?perPage=${pageSize}&page=${current}&type=search&name=${search}`)
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
                        slug: v.slug,
                        thumbnail: v.thumbnail,
                        description: v.description,
                        rating: v.rating,
                        price: this.formatRupiah(parseInt(v.price)),
                        stock: v.stock
                    })
                });
                this.items = item;
            })
            .catch(error => {
                console.error('Error fetching items:', error);
            });
        },
        fetchDataHistory(current, pageSize, search) {
            axios.get(`/api/products?perPage=${pageSize}&page=${current}&type=audits&name=${search}`)
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
        fetchDataExport() {
            this.items_export.isLoaded = true
            axios.get(`/api/products?print&categories_id=${this.exportCategories}`)
            .then(response => {
                this.items_export.isLoaded = false
                response?.data?.data?.map((v, i) => {
                    this.items_export.body.push([
                        v.id,
                        v.name,
                        v.rating,
                        v.price,
                        v.stock,
                        v.thumbnail ? JSON.parse(v.thumbnail) : '',
                        v.categories.name
                    ])
                });
            })
            .catch(error => {
                console.error('Error fetching items:', error);
            });
        },
        editRecord(record) {
            axios.get(`/api/products/${record.record.id}`)
            .then(response => {
                response?.data?.data?.map((v, i) => {
                    this.formData = {
                        id: v.id,
                        name: v.name,
                        rating: v.rating,
                        price: v.price,
                        stock: v.stock,
                        thumbnail: v.thumbnail ? JSON.parse(v.thumbnail) : '',
                        categories_id: {
                            label: v?.categories?.name,
                            value: v?.categories?.id
                        }
                    }
                });
            })
            .catch(error => {
                console.error('Error fetching items:', error);
            });
        },
        editItem() {
            this.formData.categories_id = this.formData.categories_id.value;
            axios.put(`/api/products/${this.formData.id}`, JSON.stringify(this.formData), {
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
            axios.post('/api/products', this.formData, {
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
            axios.delete('/api/products/' + this.formData.id, {
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
        fetchOptionsCategories() {
            axios.get('/api/categories')
            .then(response => {
                const option = [];
                response?.data?.data?.map((v, i) => {
                    option.push({
                        label: v.name,
                        value: v.id
                    })
                });
                this.options = option;
            })
            .catch(error => {
                console.error('Error fetching options:', error);
            })
        },
        handleSearchCategories(value) {
            this.items_export.isLoaded = true
            axios.get('/api/categories/edit?type=search&name=' + value)
            .then(response => {
                this.items_export.isLoaded = false
                const option = [];
                response?.data?.data?.map((v, i) => {
                    option.push({
                        label: v.name,
                        value: v.name
                    })
                });
                this.options = option;
            })
            .catch(error => {
                console.error('Error fetching options:', error);
            })
        },
    }
}
</script>
