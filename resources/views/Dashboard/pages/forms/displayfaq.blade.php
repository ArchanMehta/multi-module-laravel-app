<x-adminheader />
<!-- partial -->
<div class="container-fluid page-body-wrapper" style="display: contents; background: #F5F7FF">
  <div class="main-panel" style="height: 825px">
    <div class="content-wrapper">
      <div class="row">
        <div class="col-12 grid-margin stretch-card">
          <div class="card shadow-lg">
            <div class="card-body">
              <h1 class="card-title" style="color: #4B49AC; font-weight: bolder; text-align: center; margin-bottom: 20px;font-size:30px">Frequently Asked Questions</h1>
              <p class="card-description" style="color: #6B7280; font-size: 18px;font-weight:500; text-align: center; margin-bottom: 30px;">
                Find answers to the most common questions below.
              </p>

              <!-- FAQ Section -->
              <div class="accordion" id="faqAccordion">
                @foreach ($faqs as $faq)
                <div class="card mb-2" style="border: none;">
                  <!-- Question -->
                  <div class="card-header" id="heading{{ $faq->id }}" style="background-color: #4B49AC; color: white; padding: 10px 15px;">
                    <h5 class="mb-0">
                      <button
                        class="btn btn-link text-white"
                        data-toggle="collapse"
                        data-target="#collapse{{ $faq->id }}"
                        aria-expanded="false"
                        aria-controls="collapse{{ $faq->id }}"
                        style="text-decoration: none; font-size: 18px; font-weight: bold; width: 100%; text-align: left;">
                        {{ $faq->question }}
                      </button>
                    </h5>
                  </div>

                  <!-- Answer -->
                  <div id="collapse{{ $faq->id }}" class="collapse" aria-labelledby="heading{{ $faq->id }}" data-parent="#faqAccordion">
                    <div class="card-body" style="background-color: #F5F5F5; color: #494BAC; font-size: 16px; padding: 30px;">
                      {{ $faq->description }}
                    </div>
                  </div>
                </div>
                @endforeach
              </div>
              <!-- End FAQ Section -->
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- content-wrapper ends -->
    <x-adminfooter />
  </div>
</div>

<!-- Include jQuery and Bootstrap JS for Accordion functionality -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
