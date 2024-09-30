<template>
    <div>
      <v-snackbar
        v-model="snackbar"
        :timeout="timeout"
        absolute
        top
        :color="color"
      >
        <v-icon>{{ icono }}</v-icon>
        {{ text }}
      </v-snackbar>
  
      <v-row
        class="bgimagen"
        align="center"
        justify="center"
        v-if="vshow1 === true"
      >
        <v-col cols="12" sm="6" align="center" justify="center">
          <v-card
            color="rgb(220, 222, 225,0.7)"
            rounded="xl"
            elevation="15"
            class="text-md-center"
          >
            <v-card-title primary-title class="justify-center">
              <v-img
                class="align-content-center"
                src="/img/IMG_6151.PNG"
                max-width="200"
              >
              </v-img>
            </v-card-title>
            <v-card-title primary-title class="justify-center">
              Ingresa Usuario y Contraseña
            </v-card-title>
           <v-card-text>
            <v-text-field
                name="name"
                v-model="credenciales"
                label="ingrese Credencia"
                id="id"
                type="password"
            ></v-text-field>
           </v-card-text>
  
            <v-card-actions class="justify-center">
              <v-btn color="success" @click="SetPrimerLayaout()">Siguiente</v-btn>
            </v-card-actions>
          </v-card>
          <!-- <span
            >Para reservas mayores a 10 personas, por favor contáctarse al número
            xxxxxxxxxx.</span -->
          
        </v-col>
      </v-row>
      <!-- cantidad de persona -->
      <v-row 
        class="bgimagen"
        align="center"
        justify="center"
        v-if="vshow2 === true"
      >
      <v-container >
        
     
        <v-col cols="12" sm="12" align="center" justify="center">
          <v-card
            color="rgb(220, 222, 225,0.7)"
            rounded="xl"
            elevation="15"
            class="text-md-center"
          >
            <v-card-title primary-title class="justify-center">
              Datos del Sorteo
            </v-card-title>
           
            <v-card-text primary-title class="justify-center">
                <label>Seleccione Fecha inicio :</label>
              <input
                type="date"
                v-model="fecha_buscar"
                
              />
              <label>Seleccione Fecha fin :</label>
              <input
                type="date"
                v-model="fecha_buscar_hasta"
              
              />
              <v-btn color="success" @click="consultasEstacionesPorFecha()">Generar Reporte</v-btn>
              <br>
              <v-divider></v-divider>
              <v-row align="center" justify="center">
                <v-col cols="12" sm="6" class="pa-1">
                    <v-card outlined tile elevation="8" class="rounded-lg">
                    <v-system-bar color="#0288D1" dark class="white--text"
                        >Cantidad de códigos integrado por estacion</v-system-bar
                    >
                    <v-card-text>
                        <v-data-table
                            :headers="CabeceraTotalCodigo"
                            :items="ListaTotalCodigo"
                                     :items-per-page="30"
                        >
                        <template v-slot:[`item.stock`]="{ item }">
                            <v-chip
                                
                                color="success"
                                dark
                                >
                                {{ item.stock }}
                                </v-chip>         
                                        
                                            
                                        
                            </template>
                  </v-data-table>
                    </v-card-text>
                    </v-card>
                </v-col>
                <v-col cols="12" sm="6" class="pa-1">
                    <v-card outlined tile elevation="8" class="rounded-lg">
                    <v-system-bar color="#0288D1" dark class="white--text"
                        >Cantidad de Usuarios Registrados por estacion</v-system-bar
                    >
                    <v-card-text>
                        <v-data-table
                            :headers="CabeceraTotalRegistrado"
                            :items="ListaTotalRegistrado"
                                     :items-per-page="30"
                        >
                        <template v-slot:[`item.stock`]="{ item }">
                            <v-chip
                                
                                color="success"
                                dark
                                >
                                {{ item.stock }}
                                </v-chip>         
                                        
                                            
                                        
                            </template>
                  </v-data-table>
                    </v-card-text>
                    </v-card>
                </v-col>
               
              </v-row>
            </v-card-text>
           
  
            
          </v-card>
          <!-- <span
            >Para reservas mayores a 10 personas, por favor contáctarse al número
            xxxxxxxxxx.</span
          > -->
        </v-col>

        <v-col cols="12" sm="12" align="center" justify="center">
          <v-card
            color="rgb(220, 222, 225,0.7)"
            rounded="xl"
            elevation="15"
            class="text-md-center"
          >
            <v-card-title primary-title class="justify-center">
             Busqueda de cliente por identificacion
            </v-card-title>
           
            <v-card-text primary-title class="justify-center">
            <v-text-field
              name="name"
              label="Ingrese el numero de cedula"
              id="id"
              v-model="identificacion"
            ></v-text-field>
              <v-btn color="success" @click="consultasEstacionesPorFechaIdentificacion()">Generar busqueda</v-btn>
              <br>
              <v-divider></v-divider>
              <v-row align="center" justify="center">
                <v-col cols="12" sm="6" class="pa-1">
                    <v-card outlined tile elevation="8" class="rounded-lg">
                    <v-system-bar color="#0288D1" dark class="white--text"
                        >Cantidad de códigos integrado de estaciones por identificación</v-system-bar
                    >
                    <v-card-text>
                        <v-data-table
                            :headers="CabeceraTotalCodigoIdentificacion"
                            :items="ListaTotalCodigoIdentificacion"
                                     :items-per-page="30"
                        >
                        <template v-slot:[`item.stock`]="{ item }">
                            <v-chip
                                
                                color="success"
                                dark
                                >
                                {{ item.stock }}
                                </v-chip>         
                                        
                                            
                                        
                            </template>
                  </v-data-table>
                    </v-card-text>
                    </v-card>
                </v-col>
                <v-col cols="12" sm="6" class="pa-1">
                    <v-card outlined tile elevation="8" class="rounded-lg">
                    <v-system-bar color="#0288D1" dark class="white--text"
                        >Usuario registrado</v-system-bar
                    >
                    <v-card-text>
                        <v-data-table
                            :headers="CabeceraTotalRegistradoIdentificacion"
                            :items="ListaTotalRegistradoIdentificacion"
                                     :items-per-page="30"
                        >
                        <template v-slot:[`item.stock`]="{ item }">
                            <v-chip
                                
                                color="success"
                                dark
                                >
                                {{ item.stock }}
                                </v-chip>         
                                        
                                            
                                        
                            </template>
                  </v-data-table>
                    </v-card-text>
                    </v-card>
                </v-col>
               
              </v-row>
            </v-card-text>
           
  
            
          </v-card>
          <!-- <span
            >Para reservas mayores a 10 personas, por favor contáctarse al número
            xxxxxxxxxx.</span
          > -->
        </v-col>
    </v-container>
      </v-row>
       
    </div>
  </template>
  <script>
  import { forEach } from "lodash";
  import { prefix, url } from "../../variables";
  import { forIn } from "lodash";
  export default {
    props: {
      user: {
        type: Object,
      },
      invert: {
        type: Object,
      },
    },
    data() {
      return {
        vshow1: true,
        vshow2: false,
        vshow3: false,
        vshow4: false,
        vshow5: false,
        vshow6: false,
        vshow7: false,
        snackbar: false,
        color: "purple darken-4",
        text: "",
        icono: "mdi-checkbox-marked",
        timeout: 4000,
        loader: null,
        loading: false,
        icons: [],
        states: [1, 2, 3, 4, 5, 6, 7, 8, 9, 10],
        selected: "",
        fecha_buscar: new Date().toISOString().slice(0, 10),
        fecha_buscar_hasta: new Date().toISOString().slice(0, 10),
        credenciales:"Copede$@2024*-333",
        identificacion:"",
        registrar: {
          id: 0,
          id_empresa: 1,
          id_sucursal: "",
          id_mesa: "",
          numero_persona: "",
          id_cliente_reserva: "",
          fecha_reserva: new Date(
            Date.now() - new Date().getTimezoneOffset() * 60000
          )
            .toISOString()
            .substr(0, 10),
          hora_reserva: "",
          hora_estado: "",
          descripcion: "",
          celular: "",
          pago: 0,
          transaccion: "",
          valor: 0,
          des_local: "",
          des_mesa: "",
          terminos: false,
          terminoCheck: false,
        },
        mesas: [],
        justify: ["start", "center", "end", "space-around", "space-between"],
        Lista_llenar: [],
  
        e1: 1,
  
        ruta: "",
        playerOptions: {
          // videojs options
          muted: true,
          language: "en",
          playbackRates: [0.7, 1.0, 1.5, 2.0],
          sources: [
            {
              type: "video/mp4",
              src: "https://cdn.theguardian.tv/webM/2015/07/20/150716YesMen_synd_768k_vp8.webm",
            },
          ],
          poster: "/static/images/author.jpg",
        },
        dialog: false,
        form: {
          local: 0,
          mesa: 0,
          hora: "",
          celular: "",
          fecha: new Date(Date.now() - new Date().getTimezoneOffset() * 60000)
            .toISOString()
            .substr(0, 10),
          nombres: "",
          apellidos: "",
          cedula: "",
          cliente: "",
          usuario: "",
          password: "",
          comentario: "",
          correo_electronico: "",
        },
        ListHora: [],
        ListaHoraReservada: [],
        rules: {
          age: [
            (val) =>
              val < 11 ||
              `Si la cantidad es mayor a 10 personas es obligatorio cancelar la reserva`,
          ],
        },
        nameRulesCedula: [
          (v) => !!v || "Campo es Requerido",
          (v) => (v && v.length <= 10) || "Campo minimo 10 caracteres",
        ],
        nameRulesTelefono: [],
        nameRules: [
          (v) => !!v || "Campo es Requerido",
          (v) => (v && v.length <= 25) || "Campo minimo 25 caracteres",
        ],
  
        nameRules2: [
          (v) => !!v || "Campo es Requerido",
          (v) => (v && v.length <= 25) || "Name must be less than 25 characters",
        ],
  
        emailRules: [
          (v) => !!v || "E-mail is required",
          (v) => /.+@.+\..+/.test(v) || "E-mail must be valid",
        ],
        phone: {
          number: "",
          valid: false,
          country: undefined,
        },
        CabeceraTotalCodigo:[{
                    text: "Estacion",
                    align: "start",

                    value: "descripcion",
                    class: "yellow lighten-1",
                    },
                    { text: "total", value: "codigo", class: "orange lighten-1 borderWidth:8" },
                
                ],
      
      ListaTotalCodigo:[],
      CabeceraTotalRegistrado:[{
                    text: "Estacion",
                    align: "start",

                    value: "descripcion",
                    class: "yellow lighten-1",
                    },
                    { text: "total", value: "total_registro", class: "orange lighten-1 borderWidth:8" },
                
                ],
      
      ListaTotalRegistrado:[],


      CabeceraTotalCodigoIdentificacion:[{
                    text: "Estacion",
                    align: "start",

                    value: "descripcion",
                    class: "yellow lighten-1",
                    },
                    { text: "total", value: "codigo", class: "orange lighten-1 borderWidth:8" },
                
                ],
      
      ListaTotalCodigoIdentificacion:[],
      CabeceraTotalRegistradoIdentificacion:[{
                    text: "Estacion",
                    align: "start",

                    value: "descripcion",
                    class: "yellow lighten-1",
                    },
                    { text: "total", value: "total_registro", class: "orange lighten-1 borderWidth:8" },
                
                ],
      
      ListaTotalRegistradoIdentificacion:[],
      };
    },
    mounted() {
      //this.GenerarHoras();
     // this.GetSucursal();
      // this.GetHoraFecha();
    },
    computed: {
      //   player() {
      //     return this.$refs.videoPlayer.player
      //   }
    },
    methods: {
      //consultasEstacionesPorFechaIdentificacion
      consultasEstacionesPorFechaIdentificacion() {
      let that = this;
      let url =
        this.$store.getters.getRuta +
        "/modulos/sorteo/copedesa/datosEstacionesidentificacion/" +this.identificacion;
         this.ListaTotalCodigoIdentificacion = [];
         this.ListaTotalRegistradoIdentificacion = [];
    
       
      axios
        .get(url)
        .then((response) => {

          

          this.ListaTotalCodigoIdentificacion = response.data.TotalesEstaciones;
          this.ListaTotalRegistradoIdentificacion = response.data.fecha_reporte_totales_registro;

     
        })
        .catch((error) => {
          console.log("error", error);
        });
    },
        consultasEstacionesPorFecha() {
      let that = this;
      let url =
        this.$store.getters.getRuta +
        "/modulos/sorteo/copedesa/datosEstaciones/" +this.fecha_buscar+"/"+ this.fecha_buscar_hasta;
         this.ListaTotalCodigo = [];
         this.ListaTotalRegistrado = [];
    
        // this.ListaConsolidadoProducto =  [];
        // this.ListaVentasStockEstaciones = [];
        // this.ListaStockEstaciones = [];
        // let ListaEstacionesConsilidadEsPro = [];
        // let ListaVentasStockEstacionesList = [];
      axios
        .get(url)
        .then((response) => {

          

          this.ListaTotalCodigo = response.data.TotalesEstaciones;
          this.ListaTotalRegistrado = response.data.fecha_reporte_totales_registro;

     
        })
        .catch((error) => {
          console.log("error", error);
        });
    },
      onCardClick(n) {
        this.registrar.id_mesa = n.red_social_id;
        this.registrar.des_mesa = n.descripcion;
      },
      GetCliente(cedula) {
  
  
        if (cedula.length <=9) {
          return;
        }
       
        let url =
          this.$store.getters.getRuta +
          "/modulos/admision/reservas/GetCliente/" +
          cedula;
        this.Lista_llenar = [];
        axios
          .get(url)
          .then((response) => {
            this.form.apellidos = response.data.data.apellidos;
            this.form.nombres = response.data.data.nombres;
            this.form.correo_electronico = response.data.data.correo;
            
          })
          .catch((error) => {
            console.log("aqui", error);
          });
      },
  
      onInput(formattedNumber, { number, valid, country }) {
        this.phone.number = number.international;
        this.phone.valid = valid;
        this.phone.country = country && country.name;
  
        if (!this.phone.valid) {
          this.nameRulesTelefono.push("Error al Validar numero");
        } else {
          this.nameRulesTelefono = [];
          this.form.celular = this.phone.number;
        }
      },
      GetHoraFecha() {
        console.log("click");
        let ListaActual = [];
        this.ListHora = [];
        this.ListaHoraReservada = [];
        let url =
          this.$store.getters.getRuta +
          "/modulos/admision/reservas/datosEstaciones/" +
          this.registrar.fecha_reserva +
          "/" +
          this.registrar.id_sucursal +
          "/" +
          this.registrar.id_mesa;
  
        axios
          .get(url)
          .then((response) => {
            console.log("ListaActual1", response.data.data);
            // ListaActual.push(response.data.data);
            this.ListHora = response.data.listaValida;
  
            // response.data.data.forEach((element) => {
            //   let objeto = {};
            //   objeto.horthisa_reserva = element.hora_reserva;
            //   ListaActual.push(objeto);
            // });
          })
          .catch((error) => {});
  
        var names = ListaActual.map(function (item) {
          return item["hora"];
        });
  
        console.log(names);
  
        console.log("ListaActual3", names);
        //fecha de reserva
        var moment = require("moment");
        var date = moment("12:00", "HH:mm");
        var time = [];
  
        for (let k of ListaActual) {
          console.log("verificar7", k);
          // typeof (k) = string
        }
  
        console.log("verificar3", Object.values(ListaActual));
        // do {
        //   this.ListHora.push(date.format("HH:mm"));
        //   date.add(60, "minutes");
        //   //     const resultado =  this.ListaHoraReservada.includes(date.format("HH:mm"));
        // } while (date <= moment("23:59", "HH:mm"));
      },
      GetValidarHora(id) {
        console.log("horaa", id);
        this.registrar.hora_reserva = id.hora;
        console.log("horaa", this.registrar.hora_reserva);
        this.registrar.hora_estado = id.estado;
      },
      SetPrimerLayaout() {
        if (
          this.credenciales == null ||
          this.credenciales == 0
        ) {
          this.mensajeAler("Debe ingresar credencial", false);
          return;
        }

        if (this.credenciales == 'Copede$@2024*-') {
           
            this.vshow1 = false;
            this.vshow2 = true;
          
        }else{
            this.mensajeAler("Credencial incorrecta", false);
            return; 
        }
  
       
      },
      backPrimerLayaout() {
        this.vshow1 = true;
        this.vshow2 = false;
        this.vshow3 = false;
        this.vshow4 = false;
        this.vshow5 = false;
        this.vshow6 = false;
      },
      backSegundoLayaout() {
        this.vshow1 = false;
        this.vshow2 = true;
        this.vshow3 = false;
        this.vshow4 = false;
        this.vshow5 = false;
        this.vshow6 = false;
        this.ListHora = [];
      },
      backTercerLayaout() {
        this.vshow1 = false;
        this.vshow2 = false;
        this.vshow3 = true;
        this.vshow4 = false;
        this.vshow5 = false;
        this.vshow6 = false;
      },
      backCuartoLayaout() {
        this.vshow1 = false;
        this.vshow2 = false;
        this.vshow3 = false;
        this.vshow4 = true;
        this.vshow5 = false;
        this.vshow6 = false;
      },
      backQuintoLayaout() {
        this.vshow1 = false;
        this.vshow2 = false;
        this.vshow3 = false;
        this.vshow4 = true;
        this.vshow5 = false;
        this.vshow6 = false;
      },
      // SetSegundoLayaout() {
      //   this.vshow1 = false;
      //   this.vshow2 = false;
      //   this.vshow3 = true;
      // },
      SetSegundoLayaout() {
        if (
          this.registrar.numero_persona == null ||
          this.registrar.numero_persona == 0
        ) {
          this.mensajeAler("Debe Seleccionar el número de persona", false);
          return;
        }
  
        if (this.registrar.id_mesa == null || this.registrar.id_mesa == 0) {
          this.mensajeAler("Debe Seleccionar el ambiente", false);
          return;
        }
        this.vshow1 = false;
        this.vshow2 = false;
        this.vshow3 = true;
      },
      SetTercerLayaoutDatos() {
        if (this.registrar.hora_estado == 1) {
          this.mensajeAler("Esta hora no esta disponible", false);
          return;
        }
        if (
          this.registrar.hora_reserva == 0 ||
          this.registrar.hora_reserva == "" ||
          this.registrar.hora_reserva == null
        ) {
          this.mensajeAler("Debe Seleccionar Hora de reserva", false);
          return;
        }
        this.vshow1 = false;
        this.vshow2 = false;
        this.vshow3 = false;
        this.vshow4 = true;
      },
  
      SetquintoLayaoutDatos() {
        this.vshow1 = false;
        this.vshow2 = false;
        this.vshow3 = false;
        this.vshow4 = false;
        this.vshow5 = false;
        this.vshow6 = true;
      },
      SetSiguienteLocales() {
        if (
          this.registrar.numero_persona == null ||
          this.registrar.numero_persona == 0
        ) {
          this.mensajeAler("Debe Seleccionar el numero de persona", false);
          return;
        }
        if (this.registrar.id_mesa == null || this.registrar.id_mesa == 0) {
          this.mensajeAler("Debe Seleccionar tipo de Mesa", false);
          return;
        }
        this.e1 = 2;
      },
      PostGrabar() {
        if (this.registrar.terminoCheck == false) {
          this.mensajeAler("Debe Aceptar términos y condiciones", false);
          return;
        }
        this.e1 = 5;
  
        let url =
          this.$store.getters.getRuta +
          "/modulos/admision/reservas/PostValidarUsuario";
        this.Lista_llenar = [];
        axios
          .post(url, this.registrar)
          .then((response) => {
            console.log("aqui", response.data.data);
  
            window.location.replace("/");
            this.mensajeAler(true, true);
          })
          .catch((error) => {
            this.mensajeAler(true, true);
            console.log("aqui", error);
            window.location.replace("/");
  
            this.loading = false;
            this.loader = null;
          });
      },
      SetCliente() {
        //  return
        this.loading = true;
  
        this.loader = "loading";
  
        if (this.isValidCI(this.form.cedula)) {
          let url =
            this.$store.getters.getRuta +
            "/modulos/admision/reservas/PostValidarUsuarioCliente";
  
          axios
            .post(url, this.form)
            .then((response) => {
              if (response.data.data) {
                this.mensajeAler(true, true);
              } else {
                this.mensajeAler(false, true);
              }
              this.registrar.id_cliente_reserva = response.data.id;
              this.registrar.celular = this.form.celular;
              this.registrar.descripcion = this.form.comentario;
  
              this.vshow1 = false;
              this.vshow2 = false;
              this.vshow3 = false;
              this.vshow4 = false;
              this.vshow5 = true;
            })
            .catch((error) => {
              let objeto = [];
              objeto = Object.values(error.response.data.errors);
              //   console.log(objeto);
              //   console.log(objeto.length);
  
              for (let index = 0; index < objeto.length; index++) {
                // const element = array[index];
                // console.log(objeto.[index][0]);
                this.mensajeAler(objeto[index][0], false);
              }
              this.loading = false;
              this.loader = null;
            });
        } else {
          this.loading = false;
          this.loader = null;
        }
        this.loading = false;
        this.loader = null;
      },
      GenerarModal(value) {
        this.dialog = true;
      },
  
      GenerarMesas(id) {
        this.registrar.numero_persona = "";
        this.registrar.id_mesa = "";
  
        this.registrar.des_local = id.descripcion;
        this.registrar.id_sucursal = id.red_social_id;
        let url =
          this.$store.getters.getRuta +
          "/modulos/admision/reservas/GetMesasPorSucursal/" +
          id.red_social_id;
        this.Lista_llenar = [];
        axios
          .get(url)
          .then((response) => {
            response.data.data.forEach((item) => {
              let objeto = {};
  
              objeto.red_social_id = item.id;
              objeto.local = item.Sucursal_Id;
              objeto.descripcion = item.descripcion;
              objeto.icono = item.icono;
              objeto.color = item.color;
              objeto.src = item.src;
              this.Lista_llenar.push(objeto);
            });
          })
          .catch((error) => {
            console.log("aqui", error);
          });
      },
  
      objectFindByKey(array, key, value) {
        for (var i = 0; i < array.length; i++) {
          if (array[i][key] === value) {
            return array[i];
          }
        }
        return null;
      },
  
      isValidCI(ci) {
        var isNumeric = true;
        var total = 0,
          individual;
  
        for (var position = 0; position < 10; position++) {
          // Obtiene cada posición del número de cédula
          // Se convierte a string en caso de que 'ci' sea un valor numérico
          individual = ci.toString().substring(position, position + 1);
  
          if (isNaN(individual)) {
            console.log(ci, position, individual, isNaN(individual));
            isNumeric = false;
            break;
          } else {
            // Si la posición es menor a 9
            if (position < 9) {
              // Si la posición es par, osea 0, 2, 4, 6, 8.
              if (position % 2 == 0) {
                // Si el número individual de la cédula es mayor a 5
                if (parseInt(individual) * 2 > 9) {
                  // Se duplica el valor, se obtiene la parte decimal y se aumenta uno
                  // y se lo suma al total
                  total += 1 + ((parseInt(individual) * 2) % 10);
                } else {
                  // Si el número individual de la cédula es menor que 5 solo se lo duplica
                  // y se lo suma al total
                  total += parseInt(individual) * 2;
                }
                // Si la posición es impar (1, 3, 5, 7)
              } else {
                // Se suma el número individual de la cédula al total
                total += parseInt(individual);
              }
            }
          }
        }
  
        if (total % 10 != 0) {
          total = total - (total % 10) + 10 - total;
        } else {
          total = 0;
        }
  
        if (isNumeric) {
          // El total debe ser igual al último número de la cédula
          console.log(ci, total, individual);
          console.log(ci, typeof ci, ci.length);
          // La cédula debe contener al menos 10 dígitos
          if (ci.toString().length != 10) {
            this.mensajeAler(
              "La cedula ingresada debe ser de 10 digitos.",
              false
            );
  
            return false;
          }
  
          // El número de cédula no debe ser cero
          if (parseInt(ci, 10) == 0) {
            this.mensajeAler("La cedula ingresada no puede ser cero.", false);
  
            return false;
          }
  
          // El total debe ser igual al último número de la cédula
          if (total != parseInt(individual)) {
            this.mensajeAler("La cedula ingresada no es valida.", false);
            // alert("La c\u00E9dula ingresada no es v\u00E1lida.");
            return false;
          }
  
          console.log("cédula válida", ci);
          return true;
        }
  
        // Si no es un número
  
        this.mensajeAler("El dato solo puede contener numeros.", false);
        return false;
      },
      GetSucursal() {
        let url =
          this.$store.getters.getRuta + "/modulos/admision/reservas/GetSucursal";
  
        axios
          .get(url)
          .then((response) => {
            response.data.data.forEach((item) => {
              let objeto = {};
  
              objeto.red_social_id = item.Sucursal_Id;
              objeto.descripcion = item.Sucursal_Nombre;
              objeto.icono = item.campo1;
              objeto.color = item.Sucursal_Parroquia;
              objeto.url = "";
              this.icons.push(objeto);
              console.log("aqui");
            });
  
            console.log("aqui", response.data.data);
          })
          .catch((error) => {
            console.log("aqui", error);
          });
      },
      mensajeAler(value, value2) {
        if (value2) {
          if (value) {
            this.icono = "mdi-checkbox-marked";
            (this.color = "green"), (this.snackbar = true);
            this.text = "Transacción realizada de manera exitosa";
          } else {
            this.icono = "mdi-close-box";
            (this.color = "light-blue darken-4"), (this.snackbar = true);
            this.text = "Transacción actualizada de manera exitosa";
          }
        } else {
          this.icono = "mdi-close-box";
          (this.color = "red darken-4"), (this.snackbar = true);
          this.text = "Error en el sistema " + value;
        }
      },
    },
  };
  </script>
  <style  >
  .bgimagen {
    background-image: url("/img/fondo.jpg");
    background-size: cover;
    height: 110vh;
  }
  .bgimagen_dos {
    background-image: url("/img/fondo_dos.jpg");
    background-size: cover;
    height: 110vh;
  }
  .bgimagen_tres {
    background-image: url("/img/fondo_dosb.jpg");
    background-size: cover;
    height: 100vh;
  }
  .letraSpam { 
     font-size: 22px !important;
   }
  </style>
   