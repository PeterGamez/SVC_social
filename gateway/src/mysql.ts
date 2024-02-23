import { Pool, createPool } from 'mysql2/promise';

export class MySQL {
    private pool: Pool;
    private config: ConfigType;

    public constructor(config: ConfigType) {
        this.config = config;
    }

    public async connect() {
        const pool = createPool({
            host: this.config.host,
            user: this.config.user,
            password: this.config.password,
            database: this.config.database,
            waitForConnections: true,
            connectionLimit: 10,
            queueLimit: 0
        });

        pool.on("enqueue", () => {
            console.error(`[${new Date().toString().split(" ", 5).join(" ")}] Waiting for available connection slot!`);
        })

        const connection = await pool.getConnection();
        connection.release();

        console.log(`[${new Date().toString().split(" ", 5).join(" ")}] MySQL Connected!`);

        this.pool = pool;
    }

    public async getPosts({ ignore }: { ignore: number[] }) {
        let sql = `SELECT
                post.id, post.message,
                COUNT(DISTINCT post_comment.id) AS comment,
                GROUP_CONCAT(post_image.image) AS images,
                account.id AS account_id, account.username, account.avatar, account.displayname
            FROM post
            LEFT JOIN post_comment ON post_comment.post_id = post.id
            LEFT JOIN post_image ON post_image.post_id = post.id
            LEFT JOIN account ON account.id = post.account_id`
        if (ignore && ignore.length > 0) {
            sql += ` WHERE post.id NOT IN (${ignore.join(',')})`
        }
        sql += ` GROUP BY post.id
            ORDER BY RAND()
            LIMIT 4`

        const connection = await this.pool.getConnection();
        const [rows] = await connection.query(sql) as any;
        connection.release();

        const data = rows.map((row: PostType) => {
            return {
                post: {
                    id: row.id,
                    message: row.message,
                    comment: row.comment
                },
                images: row.images ? row.images.split(',') : [],
                account: {
                    id: row.account_id,
                    username: row.username,
                    avatar: row.avatar,
                    displayname: row.displayname
                }
            }
        })
        return data as PostData[];
    }

    public async getPost({ id }: { id: number }) {
        const connection = await this.pool.getConnection();
        const [rows] = await connection.query(`SELECT
                post.id, post.message,
                COUNT(DISTINCT post_comment.id) AS comment,
                GROUP_CONCAT(post_image.image) AS images,
                account.id AS account_id, account.username, account.avatar, account.displayname
            FROM post
            LEFT JOIN post_comment ON post_comment.post_id = post.id
            LEFT JOIN post_image ON post_image.post_id = post.id
            LEFT JOIN account ON account.id = post.account_id
            WHERE post.id = ${id}
            GROUP BY post.id`) as any;
        connection.release();

        const data = rows.map((row: PostType) => {
            return {
                post: {
                    id: row.id,
                    message: row.message,
                    comment: row.comment
                },
                images: row.images ? row.images.split(',') : [],
                account: {
                    id: row.account_id,
                    username: row.username,
                    avatar: row.avatar,
                    displayname: row.displayname
                }
            }
        })
        return data[0] as PostData;
    }
}

interface PostType {
    id: number;
    message: string;
    comment: number;
    images: string;
    account_id: number;
    username: string;
    avatar: string;
    displayname: string;
}

interface PostData {
    post: {
        id: number;
        message: string;
        comment: number;
    };
    images: string;
    account: {
        id: number;
        username: string;
        avatar: string;
        displayname: string;
    };
}

interface ConfigType {
    host: string;
    user: string;
    password: string;
    database: string;
}