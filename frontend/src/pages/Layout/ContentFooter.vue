<template>
  <footer class="footer">
    <div class="container">
      <nav>
        <md-list-item to="/about">
          <p>
            About Us
          </p>
        </md-list-item>
      </nav>
      <div class="copyright text-center">
        &copy; {{ new Date().getFullYear() }}
        <a href="https://www.creative-tim.com/?ref=mdf-vuejs" target="_blank"
          >Creative Tim</a
        >, made with <i class="fa fa-heart heart"></i> for a better web
      </div>
    </div>
  </footer>
</template>
<script>
export default {};
</script>
<style></style>
