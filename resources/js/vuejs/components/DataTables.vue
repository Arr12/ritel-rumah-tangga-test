<template>
    <div>
        <table ref="dataTable" class="display" width="100%"></table>
    </div>
</template>

<script>
import axios from "axios";
// import "datatables.net";
// import "datatables.net-bs4";

export default {
    mounted() {
        this.initDataTable();
    },
    methods: {
        initDataTable() {
            axios
                .get("/api/data") // Replace with your API endpoint
                .then((response) => {
                    const data = response.data;
                    const columns = Object.keys(data[0]).map((key) => ({
                        data: key,
                        title: key,
                    }));

                    $(this.$refs.dataTable).DataTable({
                        data: data,
                        columns: columns,
                    });
                })
                .catch((error) => {
                    console.error("Error fetching data:", error);
                });
        },
    },
};
</script>

<style scoped>
/* Add any custom styles here */
</style>
