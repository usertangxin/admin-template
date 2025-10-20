import path from 'path'
import fs from 'fs'
import { fileURLToPath } from 'url'

// 获取当前文件的目录路径
const __filename = fileURLToPath(import.meta.url)
const __dirname = path.dirname(__filename)
const appPath = path.resolve(__dirname, '../../')

// 读取Modules目录下所有包中的sidebar.json文件
export function loadSidebarConfigs() {
  const sidebarConfigs = []
  const modulesDir = path.resolve(appPath, 'Modules')
  
  try {
    // 读取Modules目录下的所有文件夹
    const packages = fs.readdirSync(modulesDir, { withFileTypes: true })
      .filter(dir => dir.isDirectory())
      .map(dir => dir.name)
    
    // 遍历每个包，查找并读取sidebar.json文件
    for (const pkg of packages) {
      const sidebarPath = path.resolve(modulesDir, pkg, 'docs', 'sidebar.json')
      
      // 检查文件是否存在
      if (fs.existsSync(sidebarPath)) {
        try {
          const sidebarContent = fs.readFileSync(sidebarPath, 'utf-8')
          const sidebarConfig = JSON.parse(sidebarContent)
          sidebarConfigs.push(sidebarConfig)
        } catch (error) {
          console.error(`Error reading or parsing sidebar.json for package ${pkg}:`, error)
        }
      }
    }
  } catch (error) {
    console.error('Error loading sidebar configs:', error)
  }
  
  return sidebarConfigs
}

// 动态获取features数据
export function loadFeatures() {
  const features = []
  const modulesDir = path.resolve(appPath, 'Modules')
  
  try {
    // 读取Modules目录下的所有文件夹
    const packages = fs.readdirSync(modulesDir, { withFileTypes: true })
      .filter(dir => dir.isDirectory())
      .map(dir => dir.name)
    
    // 遍历每个包，查找并读取feature.json文件
    for (const pkg of packages) {
      const featurePath = path.resolve(modulesDir, pkg,  'module.json')
      
      // 检查文件是否存在
      if (fs.existsSync(featurePath)) {
        try {
          const featureContent = fs.readFileSync(featurePath, 'utf-8')
          const featureData = JSON.parse(featureContent)
          features.push({
            title: featureData.name,
            details: featureData.description
          })
        } catch (error) {
          console.error(`Error reading or parsing feature.json for package ${pkg}:`, error)
        }
      }
    }
  } catch (error) {
    console.error('Error loading features:', error)
  }
  
  return features
}

// 遍历 modulesDir 目录并将子目录中的 docs 目录创建软链到 docs/Modules 中
export function createDocsSymlinks() {
  const modulesDir = path.resolve(appPath, 'Modules')

  if (!fs.existsSync(modulesDir)) return;

  const modules = fs.readdirSync(modulesDir);
  const docsModulesDir = path.join(__dirname, '../Modules');

  // 确保 docs/Modules 目录存在
  if (!fs.existsSync(docsModulesDir)) {
    fs.mkdirSync(docsModulesDir, { recursive: true });
  }

  for (const module of modules) {
    const modulePath = path.join(modulesDir, module);
    const stat = fs.statSync(modulePath);
    
    if (stat.isDirectory()) {
      const docsPath = path.join(modulePath, 'docs');
      if (fs.existsSync(docsPath)) {
        const targetPath = path.join(docsModulesDir, module);
        // 检查软链是否已存在，若存在则先删除
        if (fs.existsSync(targetPath)) {
          try {
            const existingStat = fs.lstatSync(targetPath);
            if (existingStat.isSymbolicLink()) {
              fs.unlinkSync(targetPath);
            }
          } catch (err) {
            console.error(`删除 ${targetPath} 时出错:`, err);
            continue;
          }
        }
        try {
          // 创建软链
          fs.symlinkSync(path.relative(path.dirname(targetPath), docsPath), targetPath, 'junction');
        } catch (err) {
          console.error(`为 ${docsPath} 创建软链到 ${targetPath} 时出错:`, err);
        }
      }
    }
  }
}