from flask import Flask, jsonify, request, send_from_directory
from flask_cors import CORS
import os

BASE_DIR = os.path.dirname(os.path.abspath(__file__))
FRONTEND_DIR = os.path.abspath(os.path.join(BASE_DIR, '..', 'frontend'))

app = Flask(__name__, static_folder=FRONTEND_DIR, static_url_path='/')
CORS(app)

# In-memory items store
items = []

@app.route('/api/items', methods=['GET'])
def get_items():
    return jsonify(items), 200

@app.route('/api/items', methods=['POST'])
def add_item():
    data = request.get_json() or {}
    text = (data.get('text') or '').strip()
    if not text:
        return jsonify({'error': 'empty'}), 400
    item = {'id': (items[-1]['id'] + 1) if items else 1, 'text': text}
    items.append(item)
    return jsonify(item), 201

@app.route('/api/items/<int:item_id>', methods=['DELETE'])
def delete_item(item_id):
    global items
    new_items = [i for i in items if i['id'] != item_id]
    if len(new_items) == len(items):
        return jsonify({'error': 'not found'}), 404
    items = new_items
    return '', 204

# Serve frontend static files
@app.route('/', defaults={'path': ''})
@app.route('/<path:path>')
def serve(path):
    # If the requested file exists in the frontend folder, serve it; otherwise return index.html
    requested = os.path.join(FRONTEND_DIR, path)
    if path and os.path.exists(requested):
        return send_from_directory(FRONTEND_DIR, path)
    return send_from_directory(FRONTEND_DIR, 'index.html')

if __name__ == '__main__':
    # Allow overriding the port via the PORT environment variable (useful if 5000 is busy)
    port = int(os.environ.get('PORT', '5000'))
    app.run(debug=True, host='0.0.0.0', port=port)
