<template>
  <v-container
    fill-height
    fluid
    grid-list-xl>
    <v-layout
      justify-center
      wrap
    >
      <v-flex
        xs12
        md8
      >
        <material-card
          color="green"
          title="Edit Profile"
          text="Complete your profile"
        >
          <v-form>
            <v-container py-0>
              <div>
                <v-tabs
                  v-model="tab"
                  background-color="deep-purple accent-4"
                  class="elevation-2"
                  dark
                  :centered="centered"
                  :grow="grow"
                  :vertical="vertical"
                  :right="right"
                  :prev-icon="prevIcon ? 'mdi-arrow-left-bold-box-outline' : undefined"
                  :next-icon="nextIcon ? 'mdi-arrow-right-bold-box-outline' : undefined"
                  :icons-and-text="icons"
                >
                  <v-tabs-slider></v-tabs-slider>

                  <!-- <v-tab
                    v-for="i in tabs"
                    :key="i"
                    :href="`#tab-${i}`"
                  >
                    Tab {{ i }}
                    <v-icon v-if="icons">mdi-phone</v-icon>
                  </v-tab> -->
                  <v-tab>User Information</v-tab>
                  <v-tab>Productivity</v-tab>
                  <v-tab-item>
                    <v-card
                      flat
                      tile
                      class="pa-4"
                    >
                      <v-layout wrap>
                        <v-flex
                          xs12
                          md4
                        >
                          <v-text-field
                            v-model="User.Kode"
                            label="Code"
                            disabled
                            counter  
                          />
                        </v-flex>
                        <v-flex
                          xs12
                          md4
                        >
                          <v-text-field
                            v-model="User.KTP"
                            label="KTP"
                            counter
                            disabled
                          />
                        </v-flex>
                        <v-flex
                          xs12
                          md4
                        >
                          <v-text-field
                            v-model="Tanggal_Masuk"
                            label="Since"
                            disabled
                          />
                        </v-flex>
                        <v-flex
                          xs12
                          md12
                        >
                        <v-textarea
          clearable
          clear-icon="cancel"
          label="Text"
          value="This is clearable text."
        ></v-textarea>
                          <v-text-field
                            v-model="User.Address"
                            label="Address"
                            counter
                          />
                        </v-flex>
                        <v-flex
                          xs12
                          md4
                        >
                          <v-text-field
                            v-model="User.Grade"
                            label="Grade"
                            counter
                          />
                        </v-flex>
                        <v-flex
                          xs12
                          md4
                        >
                          <v-text-field
                            v-model="User.Nomor_Asosiasi"
                            label="Assosiation Number"
                            counter
                          />
                        </v-flex>
                        <v-flex
                          xs12
                          md4
                        >
                          <v-text-field
                            v-model="User.Nomor_SKA"
                            label="SKA Number"
                            />
                        </v-flex>
                        
                        <v-flex
                          xs12
                          text-xs-right
                        >
                          <v-btn
                            class="mx-0 font-weight-light"
                            color="success"
                          >
                            Update Profile
                          </v-btn>
                        </v-flex>
                      </v-layout>
                    </v-card>
                  </v-tab-item>
                  <v-tab-item>
                    <v-card-text>BUBA</v-card-text>  
                  </v-tab-item>  
                </v-tabs>
              </div>
            </v-container>
          </v-form>
        </material-card>
      </v-flex>
      <v-flex
        xs12
        md4
      >
        <material-card class="v-card-profile">
          <v-avatar
            slot="offset"
            class="mx-auto d-block"
            size="130"
          >
            <img
              src="https://demos.creative-tim.com/vue-material-dashboard/img/marc.aba54d65.jpg"
            >
          </v-avatar>
          <v-card-text class="text-xs-center">
            <h5 class="category text-gray font-weight-thin mb-3">{{ User.Jabatan }}</h5>
            <h5 class="category text-gray font-weight-thin mb-3">{{ User.Divisi }}</h5>
            <h4 class="card-title font-weight-light">{{User.Nama}}</h4>
            <v-btn
              color="success"
              round
              class="font-weight-light"
            >Change Password</v-btn>
          </v-card-text>
        </material-card>
      </v-flex>
    </v-layout>
  </v-container>
</template>

<script>
import Controller from '../httpController'
import { mapGetters } from 'vuex'
export default {
  data: () => ({
    //Dialogs
    changePasswordDialog:false,
    //Dialogs
    //Tabs
    tab: null,
    text: 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.',
    icons: false,
    centered: false,
    grow: true,
    vertical: false,
    prevIcon: false,
    nextIcon: false,
    right: false,
    tabs: 2,
    //Tabs
    User : [],
    
  }),
  computed : {
    ...mapGetters({
          id_akun:'LoggedUser/Id_Akun',
          nama: 'LoggedUser/Name',
          akses:'LoggedUser/Akses',
    }),
  },
  mounted () {
    this.loaddata ()
  },
  methods : {
    async loaddata ()
    {
      try {
          this.User = ((await Controller.getallemployee()).data).filter(obj=>obj.Id_Akun == this.id_akun)[0]
          console.log(this.User)
      } catch (err) {
          console.log(err)
      }
    }
  },
}
</script>

