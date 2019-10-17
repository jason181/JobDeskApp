<template>
    <v-layout row wrap>
       <!-- Tabel Divisi -->
        <v-flex xs12 sm6>
        <v-container>
            <v-toolbar flat>
            <v-toolbar-title class="white--text">TABEL DIVISI</v-toolbar-title>
            <v-divider
                class="mx-2 white"
                inset
                vertical
            ></v-divider>

            <!-- dialog box delete -->
            <v-dialog v-model="divDelDialog" max-width="500px">
                <v-card>
                <v-card-title>
                    <span class="headline">Delete Item</span>
                </v-card-title>
                <v-card-text>
                    <h3 class="text-sm-center">Are you sure want to delete this ?</h3>
                </v-card-text>
                <v-card-actions>
                    <v-spacer></v-spacer>
                    <v-btn color="blue darken-1" flat @click="deleteDivisi()">Yes</v-btn>
                    <v-btn color="blue darken-1" flat @click="close">No</v-btn>
                    <v-spacer></v-spacer>

                    
                </v-card-actions>
                </v-card>
            </v-dialog>     

           <!-- Div Form Dialog  -->
            <v-dialog v-model="divFormDialog" persistent max-width="600px">
            <template v-slot:activator="{ on }">
                <v-btn v-if="Access('M-Role-C')==true" color="success"  dark class="mb-2" v-on="on">Tambah</v-btn>
            </template>
            <v-card>
                <v-card-title>
                <span class="headline">{{divFormTitle}}</span>
                </v-card-title>
                <v-divider></v-divider>
                <v-card-text>
                <v-container grid-list-md>
                    <v-layout wrap>
                    
                    <v-flex xs12 sm5>
                        <v-text-field 
                        v-model="editedForm.Kode" 
                        label="Kode" 
                        prepend-icon="vpn_key"
                        ></v-text-field>
                    </v-flex>
                    <v-flex xs12 sm9>
                        <v-text-field 
                        v-model="editedForm.Deskripsi" 
                        label="Deskripsi" 
                        prepend-icon="assignment_ind"
                        ></v-text-field>
                    </v-flex>

                    </v-layout>
                </v-container>
                <small>*indicates required field</small>
                </v-card-text>
                <v-divider></v-divider>
                <v-card-actions>
                <v-spacer></v-spacer>
                <v-btn color="blue darken-1" flat @click="close">Close</v-btn>
                <v-btn  flat v-if="editedIndex!=-1" color="blue darken-1"  @click="updateDivisi()">Save</v-btn>
                <v-btn  flat v-else color="blue darken-1" @click="addDivisi(editedForm);close();">Add</v-btn>
                </v-card-actions>
            </v-card>
            </v-dialog>
       
           <!-- Div Form Dialog-->     

            <!-- Search -->
            <v-spacer></v-spacer>
            <v-flex xs4 sm4 md4>
                <v-text-field 
                    v-model="divSearch"
                    append-icon="search"
                    label="Cari"
                    single-line
                    hide-details>
                </v-text-field>
            </v-flex>

            </v-toolbar>
            <!-- <VCardText
                v-if="loading || error"
                class="text-xs-center"
                >
                    <VAlert
                    v-if="error"
                    type="error"
                    dismissible
                    :value="true"
                    >
                    {{ error.message }}
                    </VAlert>
                    <VProgressCircular
                    :size="45"
                    indeterminate
                    class="loading-section"
                    />
            </VCardText> -->

            <!-- Div Tabel -->
            <v-data-table
            :headers="divHeaders"
            :items="divInitialize"
            :search="divSearch"
            class="elevation-1">
            <template v-slot:items="props">
                <td>{{ props.index+1 }}</td>
                <td>{{ props.item.Kode }}</td>
                <td class="text-xs-center">{{ props.item.Deskripsi }}</td>              
                <td class="justify-center layout px-0">
                    <v-icon
                    v-if="Access('M-Role-U')==true"
                    small
                    class="mr-2"
                    @click="editItem(props.item,'Divisi')"
                    >
                    edit
                </v-icon>
                <v-icon
                    v-if="Access('M-Role-D')==true"
                    small
                    @click="deleteItem(props.item,'Divisi')"
                >
                    delete
                </v-icon>
                </td>
            </template>
            <v-alert v-slot:no-results :value="true" color="error" icon="warning">
                Your search for "{{ search }}" found no results.
            </v-alert>
            <!-- <template v-slot:no-data>
                <v-btn color="primary" @click="initialize">Reset</v-btn>
            </template> -->
            </v-data-table>

            <!-- Alert -->
            <v-snackbar right bottom :color="alert.type"  value="true" v-if="alert.type">
            <v-icon>{{alert.icon}}</v-icon>{{alert.message}}
            </v-snackbar>
        </v-container>
    
        </v-flex>
       <!-- Tabel Divisi -->

       <!-- Tabel Jabatan -->
        <v-flex xs12 sm6> 
        <v-container>
            <v-toolbar flat>
            <v-toolbar-title class="white--text">TABEL JABATAN</v-toolbar-title>
            <v-divider
                class="mx-2 white"
                inset
                vertical
            ></v-divider>

            <!-- dialog box delete -->
            <v-dialog v-model="jabDelDialog" max-width="500px">
                <v-card>
                <v-card-title>
                    <span class="headline">Delete Item</span>
                </v-card-title>
                <v-card-text>
                    <h3 class="text-sm-center">Are you sure want to delete this ?</h3>
                </v-card-text>
                <v-card-actions>
                    <v-spacer></v-spacer>
                    <v-btn color="blue darken-1" flat @click="deleteJabatan()">Yes</v-btn>
                    <v-btn color="blue darken-1" flat @click="close">No</v-btn>
                    <v-spacer></v-spacer>

                    
                </v-card-actions>
                </v-card>
            </v-dialog>          

           <!-- Div Form Dialog  -->
            <v-dialog v-model="jabFormDialog" persistent max-width="600px">
            <template v-slot:activator="{ on }">
                <v-btn v-if="Access('M-Role-C')==true" color="success"  dark class="mb-2" v-on="on">Tambah</v-btn>
            </template>
            <v-card>
                <v-card-title>
                <span class="headline">{{jabFormTitle}}</span>
                </v-card-title>
                <v-divider></v-divider>
                <v-card-text>
                <v-container grid-list-md>
                    <v-layout wrap>
                    
                    <v-flex xs12 sm5>
                        <v-text-field 
                        v-model="editedForm.Kode" 
                        label="Kode" 
                        prepend-icon="vpn_key"
                        ></v-text-field>
                    </v-flex>
                    <v-flex xs12 sm9>
                        <v-text-field 
                        v-model="editedForm.Deskripsi" 
                        label="Deskripsi" 
                        prepend-icon="assignment_ind"
                        ></v-text-field>
                    </v-flex>

                    </v-layout>
                </v-container>
                <small>*indicates required field</small>
                </v-card-text>
                <v-divider></v-divider>
                <v-card-actions>
                <v-spacer></v-spacer>
                <v-btn color="blue darken-1" flat @click="close">Close</v-btn>
                <v-btn  flat v-if="editedIndex!=-1" color="blue darken-1"  @click="updateJabatan()">Save</v-btn>
                <v-btn  flat v-else color="blue darken-1" @click="addJabatan(editedForm);close();">Add</v-btn>
                </v-card-actions>
            </v-card>
            </v-dialog>
       
           <!-- Div Form Dialog-->     

            <!-- Search -->
            <v-spacer></v-spacer>
            <v-flex xs4 sm4 md4>
                <v-text-field 
                    v-model="jabSearch"
                    append-icon="search"
                    label="Cari"
                    single-line
                    hide-details>
                </v-text-field>
            </v-flex>

            </v-toolbar>
            <!-- <VCardText
                v-if="loading || error"
                class="text-xs-center"
                >
                    <VAlert
                    v-if="error"
                    type="error"
                    dismissible
                    :value="true"
                    >
                    {{ error.message }}
                    </VAlert>
                    <VProgressCircular
                    :size="45"
                    indeterminate
                    class="loading-section"
                    />
            </VCardText> -->

            <!-- Div Tabel -->
            <v-data-table
            :headers="jabHeaders"
            :items="jabInitialize"
            :search="jabSearch"
            class="elevation-1">
            <template v-slot:items="props">
                <td>{{ props.index+1 }}</td>
                <td>{{ props.item.Kode }}</td>
                <td class="text-xs-center">{{ props.item.Deskripsi }}</td>              
                <td class="justify-center layout px-0">
                    <v-icon
                    v-if="Access('M-Role-U')==true"
                    small
                    class="mr-2"
                    @click="editItem(props.item,'Jabatan')"
                    >
                    edit
                </v-icon>
                <v-icon
                    v-if="Access('M-Role-D')==true"
                    small
                    @click="deleteItem(props.item,'Jabatan')"
                >
                    delete
                </v-icon>
                </td>
            </template>
            <v-alert v-slot:no-results :value="true" color="error" icon="warning">
                Your search for "{{ search }}" found no results.
            </v-alert>
            <!-- <template v-slot:no-data>
                <v-btn color="primary" @click="initialize">Reset</v-btn>
            </template> -->
            </v-data-table>

            <!-- Alert -->
            <v-snackbar right bottom :color="alert.type"  value="true" v-if="alert.type">
            <v-icon>{{alert.icon}}</v-icon>{{alert.message}}
            </v-snackbar>
        </v-container>
        </v-flex>
       <!-- Tabel Jabatan -->

       <!-- Div Form Dialog  -->
       <!-- Div Form Dialog-->
    </v-layout>
</template>


<script>
  import Controller from '../httpController'
  import { mapGetters } from 'vuex'
//   import { mapState, mapActions } from 'vuex'
//   import userService from '../../service/User'

  export default {
    data: () => ({
      divFormDialog:false,
      jabFormDialog:false,
      jabDelDialog: false,
      divDelDialog: false,
      jabSearch: '',
      divSearch: '',
      i:0,
      divHeaders: [
        { text: 'No', align: 'left', sortable: false },
        { text: 'Kode', align: 'left', value: 'Kode' },
        { text: 'Deskripsi', align: 'center', value: 'Deskripsi' },
        { text: 'Actions', align: 'center',value: 'name', sortable: false }
      ],
      jabHeaders: [
        { text: 'No', align: 'left', sortable: false },
        { text: 'Kode', align: 'left', value: 'Kode' },
        { text: 'Deskripsi', align: 'center', value: 'Deskripsi' },
        { text: 'Actions', align: 'center',value: 'name', sortable: false }
      ],
      divisi:[],
      divisiData:[],
      jabatan:[],
      jabatanData:[],
      editedIndex: -1,
      alert:{
        type: null,
        message: null,
        icon: null,
      },
      editedForm:{
        Id_Divisi_Role:'',
        Id_Jabatan:'',
        Kode:'',
        Deskripsi:'',
      },
      editedFormDefault:{
        Id_Divisi_Role:'',
        Id_Jabatan:'',
        Kode:'',
        Deskripsi:'',
      },
    }),

    computed: {
      ...mapGetters({
            nama: 'LoggedUser/Name',
            akses:'LoggedUser/Akses',
      }),
      divFormTitle () {
        return this.editedIndex === -1 ? 'Tambah Dvivisi' : 'Edit Divisi'
      },
      jabFormTitle () {
        return this.editedIndex === -1 ? 'Tambah Jabatan' : 'Edit Jabatan'
      },
    //   ...mapState({
    //     loading: state => state.User.loading,
    //     error: state => state.User.error,
    //     users: state => state.User.users,
    //   }),
      divInitialize () {
        this.divisiData = this.divisi
        return this.divisiData
      },
      jabInitialize () {
        this.jabatanData = this.jabatan
        return this.jabatanData
      },

    },

    watch: {
      dialog (val) {
        val || this.close()
      },
      delDialog (val) {
        val || this.close()
      }
    },

    mounted () {
      this.loaddata ()
    //   this.getEmployee()
      // this.userfiltered()
    
    },

    methods: {
    //   ...mapActions({
    //       getEmployee: 'Employee/get',
    //       deleteEmployee: 'Employee/delete',
          
    //   }),
      async loaddata () {
        try {
   
            this.divisi = (await Controller.getalldivisirole()).data
            this.jabatan = (await Controller.getalljabatan()).data

        } catch (err) {
            console.log(err)
        }
      },
      async getDivisi(){
        try {

            this.divisi = (await Controller.getalldivisirole()).data

        } catch (err) {
            console.log(err)
        }
      },


      async addDivisi () {
        try {
            const response= await Controller.adddivisi(this.editedForm)
            console.log(response)
            this.divisiData.push(this.editedForm)
            await this.getDivisi()
            this.close()
            this.showAlert('success','Sukses Menambahkan Divisi')
        } catch (err) {
            console.log(err)
            this.showAlert('error','Gagal Menambahkan Divisi')
        }
            
      },
      async deleteDivisi(){
        try {
            var id = this.divisiData[this.editedIndex].Id_Divisi_Role
            const response = await Controller.deletedivisi(id)
            console.log(response)
            await this.getDivisi()
            this.close()
            this.showAlert('success','Sukses Hapus Divisi')

        } catch (err) {
            console.log(err)
            this.showAlert('success','Gagal Hapus Divisi')

        }
      },
      async updateDivisi () {
        try {

            const response = await Controller.updatedivisi(this.editedForm,this.editedForm.Id_Divisi_Role)
            console.log(response)
            Object.assign(this.divisiData[this.editedIndex], this.editedForm)
            await this.getDivisi()
            this.close()
            this.showAlert('success','Sukses Edit Divisi')

        } catch (err) {
            console.log(err)
            this.showAlert('error','Gagal Edit Divisi')
        }
      },


      async getJabatan(){
        try {

            this.jabatan = (await Controller.getalljabatan()).data

        } catch (err) {
            console.log(err)
        }
      },


      async addJabatan () {
        try {
            const response= await Controller.addjabatan(this.editedForm)
            console.log(response)
            this.jabatanData.push(this.editedForm)
            await this.getJabatan()
            this.close()
            this.showAlert('success','Sukses Menambahkan Jabatan')
        } catch (err) {
            console.log(err)
            this.showAlert('error','Gagal Menambahkan Jabatan')
        }
            
      },
      async deleteJabatan(){
        try {
            var id = this.jabatanData[this.editedIndex].Id_Jabatan
            const response = await Controller.deletejabatan(id)
            console.log(response)
            await this.getJabatan()
            this.close()
            this.showAlert('success','Sukses Hapus Jabatan')

        } catch (err) {
            console.log(err)
            this.showAlert('success','Gagal Hapus Jabatan')

        }
      },
      async updateJabatan () {
        try {

            const response = await Controller.updatejabatan(this.editedForm,this.editedForm.Id_Jabatan)
            console.log(response)
            Object.assign(this.jabatanData[this.editedIndex], this.editedForm)
            await this.getJabatan()
            this.close()
            this.showAlert('success','Sukses Edit Jabatan')

        } catch (err) {
            console.log(err)
            this.showAlert('error','Gagal Edit Jabatan')
        }
      },
    //   closeFormDialog(){
    //     this.formDialog= false
    //     this.editedForm = Object.assign({}, this.defaultItem)
    //   },
    //   userfiltered(){
    //     // console.log(this.userData)
    //     this.userDataFiltered = this.userData.filter(item => console.log(item));
    //     // console.log(this.userDataFiltered);
    //   },
     Access(codeAccess){

        var x;
        for(x in this.akses.data){
            if (codeAccess.includes(this.akses.data[x].Fitur)) {
                return true
            } 
        }
        return false
            
      },
      editItem (item,tabel) {
        if(tabel=='Divisi')
        {
            this.editedIndex = this.divisiData.indexOf(item)
            this.editedForm = Object.assign({}, item)
            this.divFormDialog = true
        }
        else if(tabel=='Jabatan')
        {
            this.editedIndex = this.jabatanData.indexOf(item)
            this.editedForm = Object.assign({}, item)
            this.jabFormDialog = true
        }
        
      },

      deleteItem (item,tabel) {
        if(tabel=='Divisi')
        {
            this.editedIndex = this.divisiData.indexOf(item)
            this.divDelDialog =true
        }
        else if(tabel=='Jabatan')
        {
            this.editedIndex = this.jabatanData.indexOf(item)
            this.jabDelDialog =true
        }
      
      },

      close () {
        this.divFormDialog = false
        this.jabFormDialog = false
        this.jabDelDialog = false
        this.divDelDialog =false
        setTimeout(() => {
          this.editedForm = Object.assign({}, this.defaultItem)
          this.editedIndex = -1
        }, 300)
      },
      
      showAlert (type,alert_message) {

        if(type == 'success'){
          this.alert.icon = 'done'
        }
        else if(type == 'error'){
          this.alert.icon = 'clear'
        }

        this.alert.type = type
        this.alert.message = alert_message
        
        let timer = this.showAlert.timer
        if (timer) {
          clearTimeout(timer)
        }
        this.showAlert.timer = setTimeout(() => {
            this.alert.type = null
            this.alert.icon = null
            this.alert.message = null
        }, 3000)
        
      }
      
    }
  }
</script>
