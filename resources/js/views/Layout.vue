<template>
  <div class="layout">

    <header class="header">
      <h1>My Awesome App</h1>
    </header>


    <nav class="navbar">
      <router-link to="/">Home</router-link>
      <router-link to="/about">About</router-link>
      <router-link to="/contact">Contact</router-link>
    </nav>

    <main class="main">
      <slot></slot>
    </main>

    <footer class="footer">
      &copy; {{ currentYear }} My Awesome App
    </footer>
  </div>
</template>

<script>
export default {
  data() {
    return {
      currentYear: new Date().getFullYear(),
    };
  },
};
</script>

<style>
/* Basic styling for the layout */
.layout {
  margin: 0 auto;
  display: grid;
  grid-template-areas:
    "header"
    "navbar"
    "main"
    "footer";
  grid-template-rows: auto min-content 1fr min-content;
  min-height: 100vh;
}

.header {
  grid-area: header;
  text-align: center;
  padding: 10px;
  background-color: #333;
  color: #fff;
}

.navbar {
  grid-area: navbar;
  display: flex;
  justify-content: space-around;
  align-items: center;
  background-color: #f4f4f4;
  padding: 10px;
}

.navbar a {
  text-decoration: none;
  color: #333;
}

.main {
  grid-area: main;
  padding: 20px;
}

.footer {
  grid-area: footer;
  text-align: center;
  padding: 10px;
  background-color: #333;
  color: #fff;
}
</style>
