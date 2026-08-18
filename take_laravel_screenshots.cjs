const { chromium } = require('playwright');
const path = require('path');

const ARTIFACT_DIR = 'C:\\Users\\galan\\.gemini\\antigravity\\brain\\b731553a-32dd-4bc8-ba00-1fb5d788e1da';
const BASE_URL = 'http://127.0.0.1:8000';

(async () => {
  const browser = await chromium.launch({ headless: true });
  const context = await browser.newContext({ viewport: { width: 1440, height: 900 } });
  const page = await context.newPage();

  // 1. Landing Page
  console.log('Navigating to Laravel Landing Page...');
  await page.goto(BASE_URL, { waitUntil: 'networkidle' });
  await page.screenshot({ path: path.join(ARTIFACT_DIR, '01_laravel_landing_page.png') });
  console.log('Saved 01_laravel_landing_page.png');

  // 2. Public Proposal Modal
  console.log('Opening Public Proposal Modal...');
  await page.click('button:has-text("Usulkan Isu Hukum (Publik)")');
  await page.waitForTimeout(600);
  await page.screenshot({ path: path.join(ARTIFACT_DIR, '02_laravel_modal_pengusulan.png') });
  console.log('Saved 02_laravel_modal_pengusulan.png');

  // 3. Login Page
  console.log('Navigating to Login Page...');
  await page.goto(BASE_URL + '/login', { waitUntil: 'networkidle' });
  await page.screenshot({ path: path.join(ARTIFACT_DIR, '03_laravel_login_page.png') });
  console.log('Saved 03_laravel_login_page.png');

  // 4. Dashboard Overview
  console.log('Performing Admin Login...');
  await page.click('button:has-text("Masuk Portal Dashboard")');
  await page.waitForTimeout(1000);
  await page.screenshot({ path: path.join(ARTIFACT_DIR, '04_laravel_dashboard_overview.png') });
  console.log('Saved 04_laravel_dashboard_overview.png');

  await browser.close();
  console.log('All Laravel screenshots captured successfully!');
})();
