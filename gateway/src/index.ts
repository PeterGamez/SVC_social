import WebSocket, { WebSocketServer } from 'ws';
import { MySQL } from './mysql';
import config from './config';

const DB = new MySQL(config.mysql);
run()

async function run() {
    await DB.connect()

    const wss = new WebSocketServer({ port: config.ws.port })

    wss.on('connection', function (ws: WebSocketType, req) {
        console.log(`[${new Date().toString().split(" ", 5).join(" ")}] New connection from ${req.socket.remoteAddress}`);

        ws.isAlive = true;

        ws.on('error', console.error);
        ws.on('pong', function () {
            ws.isAlive = true;
            // console.log(`[${new Date().toString().split(" ", 5).join(" ")}] Pong`);
        });
        ws.on('close', function () {
            console.log(`[${new Date().toString().split(" ", 5).join(" ")}] Connection closed`);
        });

        ws.send(JSON.stringify({ op: 0, t: 'CONNECTED', d: null }));

        ws.on('message', async function (message) {
            console.log(`[${new Date().toString().split(" ", 5).join(" ")}] Received: ${message}`);
            let json = {} as MessageType;

            try {
                json = JSON.parse(message.toString());
            } catch (error) {
                return ws.send(JSON.stringify({ op: 3, t: 'INVALID_JSON', d: null }));
            }
            if (!json.op || !json.t) return ws.send(JSON.stringify({ op: 3, t: 'INVALID_JSON', d: null }));

            if (json.op == 2) {
                if (!json.d) return ws.send(JSON.stringify({ op: 3, t: 'INVALID_JSON', d: null }));

                const { token, id } = json.d;
                if (!token || !id) return ws.send(JSON.stringify({ op: 3, t: 'INVALID_JSON', d: null }));

                if (token != 'sss') {
                    return ws.send(JSON.stringify({ op: 3, t: 'INVALID_TOKEN', d: null }));
                }
                if (json.t == 'NEW_POST') {
                    ws.send(JSON.stringify({ op: 1, t: 'RECIEVED', d: null }));

                    const post = await DB.getPost({ id: id });
                    wss.clients.forEach(function each(c) {
                        const client = c as WebSocketType
                        if (client != ws) {
                            client.postSent.push(id);
                            client.send(JSON.stringify({ op: 12, t: 'NEW_POST', d: [post] }));
                        }
                    });
                }
            }
            else if (json.op == 11) {
                if (json.t == 'GET_POSTS') {
                    const posts = await DB.getPosts({ ignore: ws.postSent })

                    if (!ws.postSent) ws.postSent = [];
                    ws.postSent = ws.postSent.concat(posts.map(p => p.post.id));

                    ws.send(JSON.stringify({ op: 12, t: 'POSTS', d: posts }));
                }
            }
        });
    });

    wss.on('listening', function () {
        console.log(`[${new Date().toString().split(" ", 5).join(" ")}] Server started on ws://localhost:${config.ws.port}`);
    });

    wss.on('close', function () {
        console.log(`[${new Date().toString().split(" ", 5).join(" ")}] Server closed`);
        clearInterval(interval);
    });

    const interval = setInterval(function ping() {
        wss.clients.forEach(function each(ws) {
            const client = ws as WebSocketType;
            if (client.isAlive === false) {
                console.log(`[${new Date().toString().split(" ", 5).join(" ")}] Terminating connection`);
                return client.terminate();
            }

            client.isAlive = false;
            client.ping(function () { });
            // console.log(`[${new Date().toString().split(" ", 5).join(" ")}] Ping`);
        });
    }, 5 * 1000);
}

interface WebSocketType extends WebSocket {
    isAlive: boolean;
    postSent: Array<number>;
}

interface MessageType {
    op: number;
    t: string;
    d: any;
}