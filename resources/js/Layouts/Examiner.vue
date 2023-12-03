<template>
    <nav class="navbar navbar-dark navbar-theme-primary px-4 col-12 d-lg-none">
        <a class="navbar-brand me-lg-5" href="/">
            <img class="navbar-brand-dark" src=""/>
            <img class="navbar-brand-light" src=""/>
        </a>
        <div class="d-flex align-items-center">
            <button class="navbar-toggler d-lg-none collapsed" type="button" data-bs-toggle="collapse"
                data-bs-target="#sidebarMenu" aria-controls="sidebarMenu" aria-expanded="false"
                aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
        </div>
    </nav>

    <!-- sidebar -->
    <ExaminerSidebar/>

    <main class="content">

        <!-- navbar -->
        <NavbarExaminer />

        <!-- content -->
        <slot />

    </main>

</template>

<script>
    //import navbar
    import NavbarExaminer from "../Components/NavbarExaminer.vue";

    //import sidebar
    import ExaminerSidebar from '../Components/ExaminerSidebar.vue';

    export default {

        //register components
        components: {
            ExaminerSidebar,
            NavbarExaminer
        },
    }

</script>

<style>

</style>
