const fs = require('fs');
let content = fs.readFileSync('Untitled-1.html', 'utf8');

content = content.replace(/–/g, '--');
content = content.replace(/[‘’]/g, "'");
content = content.replace(/[“”]/g, '"');

fs.writeFileSync('Untitled-1.html', content);
