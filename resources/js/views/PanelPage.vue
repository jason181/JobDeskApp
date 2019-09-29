<template>
  <v-content>
    <v-app
      id="panel-view"
      dark>
    
        <v-toolbar id="core-toolbar"  flat prominent>
            <div class="v-toolbar-title">
                <v-toolbar-title class="font-weight-light text-general">
                    <v-btn v-if="responsive" class="default v-btn--simple" icon @click.stop="onClickBtn">
                        <v-icon>mdi-view-list</v-icon>
                    </v-btn>
                    {{ title }}
                </v-toolbar-title>
            </div>

            <v-spacer/>
            <v-toolbar-items>
                <v-flex align-center layout py-2>
                    <v-text-field
                        v-if="responsiveInput"
                        class="mr-4 mt-2 purple-input"
                        label="Search..."
                        hide-details
                        color="purple"
                    />
                    <router-link v-ripple class="toolbar-items" to="/panel/dashboard">
                        <v-icon color>mdi-home</v-icon>
                    </router-link>
                    <v-menu bottom left content-class offset-y transition="slide-y-transition">
                        <router-link
                            v-ripple
                            slot="activator"
                            class="toolbar-items"
                            to="/panel/notifications"
                        >
                            <v-badge color="error" overlap>
                                <template slot="badge">{{ notifications.length }}</template>
                                <v-icon color>mdi-bell</v-icon>
                            </v-badge>
                        </router-link>
                        <v-card>
                            <v-list dense>
                                <v-list-tile v-for="notification in notifications" :key="notification" @click="onClick">
                                    <v-list-tile-title v-text="notification"/>
                                </v-list-tile>
                            </v-list>
                        </v-card>
                    </v-menu>
                    <router-link v-ripple class="toolbar-items" to="/panel/user-profile">
                        <v-icon color>mdi-account</v-icon>
                    </router-link>

                    <v-icon class="toolbar-items" color @click="logout">mdi-power</v-icon>
                </v-flex>
            </v-toolbar-items>
        </v-toolbar>

      <!-- <core-toolbar /> -->

        <v-navigation-drawer
            id="app-drawer"
            v-model="inputValue"
            app
            dark
            floating
            persistent
            mobile-break-point="991"
            width="260"
            >
            <v-img
            :src="image"
            height="100%"
            >
            <v-layout
                class="fill-height"
                tag="v-list"
                column
            >
                <v-list-tile avatar>
                <v-list-tile-avatar
                    color="grey"
                >
                    <v-img
                    :src="logo"
                    height="64"
                    contain
                    />
                </v-list-tile-avatar>
                <v-list-tile-title class="title">
                    Work Panel
                </v-list-tile-title>
                </v-list-tile>
                <v-divider/>
                <v-list-tile>
                 <span class="white--text subheading mt-1"> <v-icon>person</v-icon> Nama Lengkap</span>
                </v-list-tile>
                <v-list-tile>
                 <span class="white--text subheading mt-1"> <v-icon>work</v-icon> Divisi</span>
                </v-list-tile>
                <v-list-tile>
                 <span class="white--text subheading mt-1"> <v-icon>spa</v-icon> Jabatan</span>
                </v-list-tile>
                
                <v-divider/>

                <v-list-tile
                v-if="responsive"
                >
                <v-text-field
                    class="purple-input search-input"
                    label="Search..."
                    color="purple"
                />
                </v-list-tile>
                <v-list-tile
                v-for="(link, i) in links"
                :key="i"
                :to="link.to"
                :active-class="color"
                avatar
                class="v-list-item"
                >
                <v-list-tile-action>
                    <v-icon>{{ link.icon }}</v-icon>
                </v-list-tile-action>
                <v-list-tile-title
                    v-text="link.text"
                />
                </v-list-tile>
            </v-layout>
            </v-img>
        </v-navigation-drawer>
      <!-- <core-drawer /> -->

      <v-fade-transition mode="out-in">
        <router-view />
      </v-fade-transition>

      <!-- <core-footer v-if="$route.name !== 'Maps'" /> -->

    </v-app>
  </v-content>
</template>

<script>
// import { mapMutations, mapGetters } from "vuex";
export default {
//   name: 'DashboardView',
//   metaInfo () {
//     return {
//       title: 'Vuetify Admin Dashboard by ClintOxx'
//     }
//   }

	

    data: () => ({
        notifications: [
            "Mike, Thanos is coming",
            "5 new avengers joined the team",
            "You're now friends with Capt",
            "Another Notification",
            "Another One - Dj Khalid voice"
        ],
        title: "Panel",
        responsive: false,
        responsiveInput: false,
         logo: 'http://localhost:8000/img/reunion.png',
        links: [
        {
            to: '/panel/dashboard',
            icon: 'mdi-view-dashboard',
            text: 'Dashboard'
        },
        // {
        //     to: '/panel/user-profile',
        //     icon: 'mdi-account',
        //     text: 'User Profile'
        // },
        {
            to: '/panel/job-desk',
            icon: 'assignment_turned_in',
            text: 'Job Desk'
        },
        {
            to: '/panel/job-desk2',
            icon: 'assignment_turned_in',
            text: 'Job Desk V2'
        },
        {
            to: '/panel/job-desk3',
            icon: 'assignment_turned_in',
            text: 'Job Desk V3'
        },
        ],
        color: 'general',
        image :'',
        inputValue: {
            drawer: null,
            color: 'general',
            image :'',
        }
    
    }),

    computed: {
        // ...mapGetters(["authorized"])

        items () {
            return this.$t('Layout.View.items')
        }
    },

    watch: {
        $route(val) {
            this.title = val.meta.name;
        }
    },

    mounted() {
        this.onResponsiveInverted();
        window.addEventListener("resize", this.onResponsiveInverted);
    },
    beforeDestroy() {
        window.removeEventListener("resize", this.onResponsiveInverted);
    },

    methods: {
        // ...mapMutations("app", ["setDrawer", "toggleDrawer"]),
        // onClickBtn() {
        //     this.setDrawer(!this.$store.state.app.drawer);
        // },
        onClick() {
            //
        },
        onResponsiveInverted() {
            if (window.innerWidth < 991) {
                this.responsive = true;
                this.responsiveInput = false;
            } else {
                this.responsive = false;
                this.responsiveInput = true;
            }
        },
        logout: function() {
            // this.$store.dispatch("logout").then(() => {
                this.$router.push("/login");
            // });
        }
    }
};
</script>

<style lang="scss">
	#core-toolbar a {
		text-decoration: none;
	}

    #app-drawer {
        .v-list__tile {
        border-radius: 4px;

        &--buy {
            margin-top: auto;
            margin-bottom: 17px;
        }
        }

        .v-image__image--contain {
        top: 9px;
        height: 60%;
        }

        .search-input {
        margin-bottom: 30px !important;
        padding-left: 15px;
        padding-right: 15px;
        }
    }
</style>
