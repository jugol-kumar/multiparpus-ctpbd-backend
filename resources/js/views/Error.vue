<template>
    <div class="page-not-found pt-5">
        <div class="bg-light shadow">
            <h2>404</h2>
            <h3 class="mt-4">Opps! Page Not Found</h3>
<!--            <p>Lorem Ipsum is simply dummy text of the printing and<br>typesetting industry.</p>-->
<!--            <div class="mt-5">-->
<!--                <button type="button" class="btn m-2 m-md-0 btn-primary"><i class="bi bi-house-door-fill"></i> Back Home</button>-->
<!--                <button type="button" class="btn m-2 m-md-0 btn-success"><i class="bi bi-person-lines-fill"></i> Contact Us</button>-->
<!--            </div>-->
        </div>
    </div>
</template>

<script setup>

</script>
<style>
.page-not-found{
    display:flex;
    align-items:center;
    justify-content:center;
}
.page-not-found h2 {
    font-size: 130px;
    color: #e91e63;
}
.page-not-found h3 {
    font-size: 42px;
}
.page-not-found .bg-light {
    width: 50%;
    padding: 50px;
    text-align: center;
    border-radius: 5px;
    position: absolute;
    top: 50%;
    left: 58%;
    transform: translate(-50%, -50%);
}

@media (max-width:  767px) {
    .page-not-found h2 {
        font-size: 100px;
    }
    .page-not-found h3 {
        font-size: 28px;
    }
    .page-not-found .bg-light {
        width: 100%;
    }
}
</style>
