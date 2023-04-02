/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

import './bootstrap';
import { createApp } from 'vue';

/**
 * Next, we will create a fresh Vue application instance. You may then begin
 * registering components with the application instance so they are ready
 * to use in your application's views. An example is included for you.
 */


const app = createApp({
    data() {
            return {
                message: '',
                chat: {
                    message: [],
                    user: [],
                    color: [],
                    time: []
                },
                typing: '',
                numberOfUsers: 0
        }
    },

    watch: {
        message() {
            Echo.private(`chat`)
                .whisper('typing', {
                    name: this.message
            });   
        }
    },

    mounted() {

        this.getOldMessage()

        Echo.private(`chat`)
            .listen('ChatEvent', (e) => {
                this.chat.message.push(e.message);
                this.chat.user.push(e.user.name);
                this.chat.color.push('warning');
                this.chat.time.push(this.getTime());
                axios.post('/saveToSession', {
                    chat: this.chat,
                }).then(response => {

                }).catch(error => {
                    console.log(error)
                })
        })
        .listenForWhisper('typing', (e) => {
            console.error(e);
            if(e.name != '') {
                this.typing = "typing..."
            } else {
                this.typing = ''
            }

        })
        
        Echo.join(`chat`)
        .here((users) => {
            this.numberOfUsers = users.length
        })
        .joining((user) => {
            this.numberOfUsers += 1

        })
        .leaving((user) => {
            this.numberOfUsers -= 1
            this.$notify({
                // group name
                group: 'myGroup',
                // Title (HTML Content is supported)
                title: 'Notification Title',
                // Content (HTML Content is supported)
                text: 'Notification Message',
                // Class that will be assigned to the notification
                type: 'warn',
                // Time (in ms) to keep the notification on screen
                duration: 10000,
                // Time (in ms) to show / hide notifications
                speed: 1000,
                // Data object that can be used in your template
                data: {}
              })
        })
        .error((error) => {
            console.error(error);
        });
    },

    methods: {
        async send() {
            if(this.message.length != 0) {
                this.chat.message.push(this.message);
                this.chat.user.push('you');
                this.chat.color.push('success');
                this.chat.time.push(this.getTime());
                
                axios.post('/send', {

                    message: this.message,
                    chat: this.chat,
                }).then(response => {
                    this.message = ''
                    console.log(response)
                }).catch(error => {
                    console.log(error)
                })
            }

            await this.$nextTick()
            this.$refs.chat.scrollTop = this.$refs.chat.scrollHeight;

        },

        getOldMessage() {
            axios.post('/getOldMessage').then(response => {
                console.log(response)
                if(response.data != '') {
                    this.chat = response.data
                }
            }).catch(error => {
                console.log(error)
            })
        },

        getTime() {
            let time = new Date();
            return time.getHours()+':'+time.getMinutes()
        },

        deleteSession() {
            axios.get('/deleteSession').then(response => {
                this.chat = {
                    message: [],
                    user: [],
                    color: [],
                    time: []
                }
            }).catch(error => {
                console.log(error)
            })
        }
    }
});

import MessageComponent from './components/MessageComponent.vue';
import axios from 'axios';
import Notifications from '@kyvg/vue3-notification'

app.component('message-component', MessageComponent);
app.use(Notifications)

app.mount('#app');
