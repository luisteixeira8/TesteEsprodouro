const fs = require('fs');
const content = fs.readFileSync('Untitled-1.html', 'utf8');

const styleRegex = /<style>([\s\S]*?)<\/style>/i;
const scriptRegex = /<script>([\s\S]*?)<\/script>/i;

const styleMatch = content.match(styleRegex);
const scriptMatch = content.match(scriptRegex);

if (styleMatch && scriptMatch) {
  const css = styleMatch[1].trim();
  const js = scriptMatch[1].trim();

  let html = content.replace(styleRegex, '<link rel="stylesheet" href="style.css">');
  html = html.replace(scriptRegex, '<script src="app.js"></script>');

  fs.writeFileSync('style.css', css);
  fs.writeFileSync('app.js', js);
  fs.writeFileSync('index.html', html);
  console.log('Files split successfully.');
} else {
  console.error('Could not find style or script tags.');
}
