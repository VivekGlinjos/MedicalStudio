<?php

namespace Database\Seeders;

use App\Models\BlogPost;
use Illuminate\Database\Seeder;

class BlogPostSeeder extends Seeder
{
    public function run(): void
    {
        $posts = [
            [
                'title'        => 'NEET-PG 2025 Counselling: Complete Round-by-Round Guide',
                'slug'         => 'neet-pg-2025-counselling-guide',
                'category'     => 'Counselling Guide',
                'excerpt'      => 'A comprehensive guide to the NEET-PG 2025 counselling process — rounds, deadlines, documents, key strategies for AIQ seats, and what to do in each round.',
                'content'      => '<h2>What is NEET-PG Counselling?</h2><p>NEET-PG counselling is the process through which qualified NEET-PG candidates secure admission to MD/MS/PG Diploma programs in government, deemed, and central universities across India. The Medical Counselling Committee (MCC) conducts centralized counselling for the 50% All India Quota (AIQ) seats.</p><h2>Counselling Rounds at a Glance</h2><p>The MCC typically conducts 3 main rounds plus an Online Stray Vacancy (OSVR) round:</p><ul><li><strong>Round 1</strong> — Initial allotment based on choices and merit</li><li><strong>Round 2</strong> — Upgradation opportunities; fresh registration allowed</li><li><strong>Round 3 (Mop-up)</strong> — Remaining vacancies after Round 2 join/withdrawal</li><li><strong>Stray Vacancy Round</strong> — Limited round for remaining seats</li></ul><h2>Key Documents Required</h2><p>Ensure you have the following documents ready before registration:</p><ul><li>NEET-PG scorecard and admit card</li><li>MBBS degree certificate or provisional pass certificate</li><li>Internship completion certificate</li><li>Attempt certificate from the medical institution</li><li>Category certificate (SC/ST/OBC/EWS) in Central Government format</li><li>Identity proof (Aadhaar/Passport)</li><li>Recent passport-size photographs</li></ul><h2>Strategy Tips from Medical Studio Experts</h2><p>Our counsellors have guided 5,000+ students through this process. Here are the key strategies:</p><ul><li>Always fill the maximum allowed choices — never leave slots empty</li><li>Order choices by preference, not by what you think you\'ll get</li><li>Watch for "negative shifts" — branches that become harder to get in later rounds</li><li>If you have a good seat in Round 2, think twice before opting for upgradation</li></ul><blockquote>One wrong choice ordering or a missed deadline can cost you your seat permanently. That\'s why expert guidance matters.</blockquote><p>Contact Medical Studio for personalized counselling support on <a href="tel:+919747500002">+91 97475 00002</a>.</p>',
                'author'       => 'Medical Studio Team',
                'published'    => true,
                'published_at' => now()->subDays(2),
            ],
            [
                'title'        => 'How to Build the Perfect NEET-PG Choice List',
                'slug'         => 'how-to-build-neet-pg-choice-list',
                'category'     => 'Strategy',
                'excerpt'      => 'Avoid the biggest mistake of NEET-PG counselling: a badly ordered choice list. Here\'s how to build one that maximizes your chances of getting your dream specialty.',
                'content'      => '<h2>Why Your Choice List is Everything</h2><p>Your preference list is the single most important document you submit during NEET-PG counselling. The MCC system allots seats strictly based on merit rank AND the order of choices you submit. A poorly ordered list can result in a lower branch or a distant college — even if your rank deserves better.</p><h2>Step 1: Prioritize by Specialty First</h2><p>Start by listing your top specialties. MD General Medicine, MD Radiology, MS Orthopaedics, and MS Obstetrics & Gynaecology are typically the most sought-after. List your dream specialty at the top regardless of whether you think you\'ll get it.</p><h2>Step 2: Apply Quota and Category Filters</h2><p>Use our Seat Predictor to identify realistic options under your category (UR/OBC/SC/ST/EWS) and quota (AIQ/Deemed/Central Universities). This narrows down your search significantly.</p><h2>Step 3: Check the Historical Closing Ranks</h2><p>Review the last 3 years of closing ranks for each institute-specialty combination. Look for:</p><ul><li>Consistent closers (stable from year to year)</li><li>"Negative shift" institutes (getting harder each year)</li><li>Opportunities that opened up due to Virtual Vacancies</li></ul><h2>Step 4: Add Safe, Moderate, and Ambitious Choices</h2><p>Structure your list with a balance:</p><ul><li><strong>Safe choices</strong> — Institutes where your rank is comfortably within the historical closer</li><li><strong>Moderate choices</strong> — Realistic with some risk</li><li><strong>Ambitious choices</strong> — Reaching beyond your expected range (top of the list)</li></ul><h2>Step 5: Never Skip a Location for Fee Alone</h2><p>Government college fees are capped. Don\'t skip a better specialty in one city just because you prefer another city. Specialty first, location second.</p><blockquote>Medical Studio\'s Choice List Builder tool helps you simulate, optimize and lock your final list before you submit on the MCC portal.</blockquote>',
                'author'       => 'Medical Studio Experts',
                'published'    => true,
                'published_at' => now()->subDays(7),
            ],
            [
                'title'        => 'Kerala vs Karnataka: MBBS Admission 2025 Comparison',
                'slug'         => 'kerala-vs-karnataka-mbbs-admission-comparison',
                'category'     => 'College Comparison',
                'excerpt'      => 'Comparing fees, bonds, stipend, and clinical exposure across top government medical colleges in Kerala and Karnataka to help you make the right MBBS admission decision.',
                'content'      => '<h2>Overview</h2><p>Kerala and Karnataka are two of the most sought-after states for MBBS admissions in South India. Both states have excellent government medical colleges, but they differ significantly in fee structures, bond requirements, and clinical exposure opportunities.</p><h2>Kerala: Key Highlights</h2><ul><li>Government medical college fees are among the lowest in India (₹5,000–₹30,000/year)</li><li>Top colleges: Government Medical College Thiruvananthapuram, Kozhikode Medical College, Kottayam Medical College</li><li>No mandatory rural bond in most government colleges</li><li>Strong clinical exposure due to high patient load</li><li>Medium competition for state quota seats (KEAM-based)</li></ul><h2>Karnataka: Key Highlights</h2><ul><li>Government medical college fees: ₹10,000–₹50,000/year</li><li>Top colleges: BMCH Bangalore, KIMS Hubli, Mysore Medical College</li><li>Some government colleges require rural bond service (2–5 years)</li><li>Excellent research infrastructure especially in Bengaluru colleges</li><li>High competition; NEET cutoffs are typically higher</li></ul><h2>Fee Comparison Table</h2><p>For 2024-25 (approximate, government quota):</p><ul><li>Kerala Govt College: ₹5,500–₹25,000/year</li><li>Karnataka Govt College: ₹15,000–₹50,000/year</li><li>Kerala Management Quota: ₹5–₹15 Lakhs/year</li><li>Karnataka Management Quota: ₹8–₹25 Lakhs/year</li></ul><h2>Tamil Nadu: Worth Considering Too</h2><p>Tamil Nadu also offers excellent government colleges like Madras Medical College and Stanley Medical College with very low fees and high clinical exposure. For students from Tamil Nadu, state quota seats are the primary path.</p><h2>Our Recommendation</h2><p>The best state for you depends on your NEET score, category, financial situation, and specialty preference. Contact Medical Studio for a personalized analysis.</p><blockquote>Our counsellors can analyze your NEET score and suggest the best state + college combination for your specific situation.</blockquote><p>Call us: <a href="tel:+919747500002">+91 97475 00002</a></p>',
                'author'       => 'Medical Studio Team',
                'published'    => true,
                'published_at' => now()->subDays(14),
            ],
            [
                'title'        => 'Understanding Virtual vs Clear-Cut Vacancies in NEET-PG Counselling',
                'slug'         => 'virtual-vs-clear-cut-vacancies-neet-pg',
                'category'     => 'Counselling Guide',
                'excerpt'      => 'One of the most confusing aspects of NEET-PG counselling is understanding the difference between virtual and clear-cut vacancies. This guide explains it simply.',
                'content'      => '<h2>What Are Clear-Cut Vacancies?</h2><p>Clear-cut vacancies are seats that remain unallotted from a previous counselling round. These are seats that no one selected, or seats that were selected but the candidate withdrew. They are straightforwardly available — if your rank qualifies, you get the seat.</p><h2>What Are Virtual Vacancies?</h2><p>Virtual vacancies are more complex. These are seats currently occupied by a candidate who has opted for upgradation (i.e., they want a better college/specialty). If that candidate gets an upgrade in the next round, their current seat becomes a vacancy. However, until they actually move, the seat is "virtual" — it might open or it might not.</p><h2>Why Does This Matter?</h2><p>Many students see a low-closing-rank college appear available in later rounds and assume it\'s an easy get. But if most of those seats are virtual, the actual availability depends on whether higher-ranked candidates move on. If they don\'t upgrade, those virtual seats remain occupied and you don\'t get them.</p><h2>How Medical Studio Helps</h2><p>Our Allotment Mapping tool tracks real-time candidate movement. We can tell you:</p><ul><li>Which institutes have more clear-cut vs virtual vacancies</li><li>The probability of virtual seats opening up based on historical patterns</li><li>Whether it\'s worth waiting for Round 3 or joining in Round 2</li></ul><h2>The Stray Vacancy Round</h2><p>After Round 3, MCC conducts an Online Stray Vacancy Round for remaining clear-cut seats only. This is your last chance — and the stakes are high. If you don\'t join after the Stray Round, your security deposit is forfeited.</p><blockquote>Understanding vacancy types is one of the most important skills in NEET counselling. Our experts can guide you through every round with real data.</blockquote>',
                'author'       => 'Medical Studio Experts',
                'published'    => true,
                'published_at' => now()->subDays(21),
            ],
            [
                'title'        => 'INICET 2025: Complete Guide for AIIMS PG Admissions',
                'slug'         => 'inicet-2025-guide-aiims-pg-admissions',
                'category'     => 'Exam Guide',
                'excerpt'      => 'INICET is the gateway to AIIMS PG programs. This comprehensive guide covers eligibility, exam pattern, counselling process, and preparation strategy for INICET 2025.',
                'content'      => '<h2>What is INICET?</h2><p>INICET (Institute of National Importance Combined Entrance Test) is conducted twice a year for admission to MD/MS/PG Diploma programs at all seven AIIMS institutes: AIIMS New Delhi, Bhopal, Bhubaneswar, Jodhpur, Patna, Raipur, and Rishikesh.</p><h2>Key Eligibility Criteria</h2><ul><li>MBBS degree from a recognized university</li><li>Completion of compulsory rotating internship</li><li>Must be registered with MCI/NMC or State Medical Council</li><li>No age bar for INICET</li></ul><h2>INICET vs NEET-PG</h2><p>Unlike NEET-PG which covers all government and deemed universities, INICET is exclusively for AIIMS institutes. However, INICET scores are also used for admission to JIPMER (Puducherry and Karaikal) and PGIMER (Chandigarh).</p><h2>Exam Pattern</h2><ul><li>200 multiple choice questions</li><li>Duration: 3.5 hours</li><li>Marking: +4 for correct, -1 for incorrect</li><li>Subjects: Pre-clinical, Para-clinical, and Clinical</li></ul><h2>Seats Available at AIIMS Institutes</h2><p>AIIMS New Delhi alone has 100+ PG seats across specialties, with the highest demand for MD Internal Medicine, MD Radiology, MD Dermatology, and surgical branches.</p><h2>Counselling Process</h2><p>INICET counselling is conducted by AIIMS New Delhi on behalf of all AIIMS institutes. It typically has 2–3 rounds.</p><blockquote>Medical Studio offers dedicated INICET counselling support. Our experts help you navigate seat choice for AIIMS — call us at +91 97475 00002.</blockquote>',
                'author'       => 'Medical Studio Team',
                'published'    => true,
                'published_at' => now()->subDays(28),
            ],
        ];

        foreach ($posts as $post) {
            BlogPost::updateOrCreate(['slug' => $post['slug']], $post);
        }
    }
}
