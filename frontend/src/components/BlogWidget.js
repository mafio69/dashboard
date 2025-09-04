
import React, { useState, useEffect } from 'react';
import { fetchBlogPosts } from '../services/api';

const BlogWidget = () => {
    const [posts, setPosts] = useState([]);

    useEffect(() => {
        fetchBlogPosts().then(setPosts).catch(console.error);
    }, []);

    return (
        <div className="blog-widget">
            <h2>Najnowsze wpisy na blogu</h2>
            <ul>
                {posts.map(post => (
                    <li key={post.id}>
                        <h3>{post.title}</h3>
                        <p>{post.excerpt}</p>
                        <a href={`/blog/${post.id}`}>Czytaj więcej</a>
                    </li>
                ))}
            </ul>
        </div>
    );
};

export default BlogWidget;
